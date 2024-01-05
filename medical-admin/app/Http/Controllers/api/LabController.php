<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pharmacy;
use App\Models\Laboratorist;
use App\Models\Labtest;
use App\Models\Labtestcategory;
use App\Models\Labtestpackage;
use App\Models\User;
use App\Models\Blogs;
use App\Models\BlogComment;
use App\Models\Bloodbank;
use App\Models\Bloodbankstock;
use App\Models\BloodbankComponent;
use App\Models\BloodDoner;
use App\Models\Nursing;
use App\Models\Dealer;
use App\Models\AccreditionCertificate;
use App\Models\Ambulance;
use App\Models\AmbulanceBooking;
use App\Models\Ambulance_driver_list;
use App\Models\Ambulance_list;
use App\Models\DealerProduct;
use App\Models\NursingProcedure;
use App\Models\Labtest_masterdb;
use App\Models\DeliveryBoy;
use Illuminate\Support\Str;
use Auth;
use Validator;
use Hash;
use DB;

class LabController extends Controller
{
  function createUser($data)
  {
    $user = new User();
    $user->uid = $data['uid'];
    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->mobile = $data['mobile'];
    $user->password = $data['password'];
    $user->type = $data['type'];
    $user->is_verified = '0';
    $user->save();
    return $user->id;
  }
  public function getBlogList(Request $request)
  { 
      $bblist = DB::table('blogs')
      ->select('blogs.*', 'doctors.full_name as author')
      ->join('users', 'users.id', '=', 'blogs.uid')
      ->join('doctors', 'doctors.id', '=', 'users.uid')
      ->where('blogs.is_deleted', '0')->orderBy('id','desc')->limit(10);
      if ($request->id && $request->id != '') {
        $blogList = $bblist->where('id', $request->id)->first();
        $blogList->image = asset('uploads/' . $blogList->image); 
      } else if ($request->slug && $request->slug != '') {
        $blogList = $bblist->where('blogs.slug', $request->slug)->first();
         $blogList->image = asset('uploads/' . @$blogList->image); 
      } else {
        if(isset($request->skip) && $request->skip != ''){
          $bblist->skip($request->skip);
        }
        if(isset($request->limit) && $request->limit != ''){
          $bblist->take($request->limit);
        }
        $blogList = $bblist->get();
        // if (!empty($user) && $user->role != 'User') {
        //   $blist = $blist->where('uid', $user->uid);
        // }
        
      }
      return successResponse('Blog List',$blogList, \Config::get('constants.status_code.SUCCESS'));
    
  }
  public function getBlogListUser(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      if ($request->id) {
        $blogList = Blogs::where('id', $request->id)->where('uid', $user->id)->where('is_deleted', '0')->first();
        $blogList->image = asset('uploads/' . $blogList->image);
      } else {
        $blogList = Blogs::where('uid', $user->id)->get();
      }
      return successResponse('Blog List', array('data' => $blogList), \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateBlogInfo(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'title' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $data = $request->all();
        if ($data['id'] != '') {
          $blogInfo = Blogs::where('uid', $user->id)->where('id', $data['id'])->first();
          //$blogInfo->slug = $this->createSlug($data['title'], $data['id']);
        } else {
          $blogInfo = new Blogs;
          $blogInfo->uid = $user->id;
          $blogInfo->type = $user->type;
          $blogInfo->slug = $this->createSlug($data['title'], 0);
        }

        $blogInfo->title = $data['title'];
        $blogInfo->date = $data['date'];
        $blogInfo->desc = $data['desc'];
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'uploads');
          if ($image['status']) {
            $blogInfo->image = $image['file_name'];
          }
        }

        $blogInfo->save();

        return successResponse('Successfull', $blogInfo, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {
      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function submitBlogComment(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $data = $request->all();

        $comment = new BlogComment;
        $comment->blog_id = $data['blog_id'];
        $comment->name = $data['name'];
        $comment->email = $data['email'];
        $comment->comment = $data['comment'];

        $comment->save();

        return successResponse('Comment posted and reached to author', $comment, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {
      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function createSlug($title, $id = 0)
  {
    $slug = Str::slug($title);
    $allSlugs = $this->getRelatedSlugs($slug, $id);
    if (!$allSlugs->contains('slug', $slug)) {
      return $slug;
    }

    $i = 1;
    $is_contain = true;
    do {
      $newSlug = $slug . '-' . $i;
      if (!$allSlugs->contains('slug', $newSlug)) {
        $is_contain = false;
        return $newSlug;
      }
      $i++;
    } while ($is_contain);
  }
  protected function getRelatedSlugs($slug, $id = 0)
  {
    return Blogs::select('slug')->where('slug', 'like', $slug . '%')
      ->where('id', '<>', $id)
      ->get();
  }
  public function testPackageListForLab(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      if ($request->id) {
        $testList = Labtestpackage::where('id', $request->id)->where('lab_id', $user->uid)->where('is_deleted', '0')->first();
        $testList->image = asset('laboratorist_image/' . $testList->image);
      } else {
        $testList = Labtestpackage::where('lab_id', $user->uid)->get();
      }
      return successResponse('Lab Staff List', array('data' => $testList), \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateLabTestPackageForLab(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'package_name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $data = $request->all();
        if ($data['id'] != '') {
          $labtest = Labtestpackage::where('lab_id', $user->uid)->where('id', $data['id'])->first();
        } else {
          $labtest = new Labtestpackage;
        }
        $labtest->lab_id = $user->uid;
        $labtest->test_ids = $data['test_ids'];
        $labtest->package_name = $data['package_name'];
        $labtest->price = $data['price'];
        $labtest->discount = $data['discount'];
        $labtest->home_sample_collection = $data['home_sample_collection'];
        $labtest->report_home_delivery = $data['report_home_delivery'];
        $labtest->ambulance_available = $data['ambulance_available'];
        if($labtest->ambulance_available == 'Yes'){
          $labtest->ambulance_fee = $data['ambulance_fee'];
        }
       
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'laboratorist_image');
          if ($image['status']) {
            $labtest->image = $image['file_name'];
          }
        }

        $labtest->save();

        return successResponse('Successfull', $labtest, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function testListForLab(Request $request)
  {
    $user = Auth::guard('api')->user();

    if (!$user) {
        return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
    $query = Labtest::where('lab_id', $user->uid)->where('is_deleted', '0');
    if ($request->id) {
      $testList = $query->where('id', $request->id)->first();
      $testList->image = asset('laboratorist_image/' . $testList->image);
      $cat = [];
    } else {
      $testList = $query->select('*')->orderBy('id', 'DESC')->get();
      $cat = Labtestcategory::all();
    }
      return successResponse('Lab Staff List', array('data' => $testList, 'cat' => $cat), \Config::get('constants.status_code.SUCCESS'));
    
  }
  public function listNursingProcedureAll(Request $request)
  {
    $list = NursingProcedure::where('status', '1')->where('is_deleted', '0');
    if ($request->id != '') {
      $list->where('id', $request->id);
    }
    if ($request->nid != '') {
      $list->where('nursing_id', $request->nid);
    }
    $testList = $list->get();
    return successResponse('List', $testList, \Config::get('constants.status_code.SUCCESS'));
  }
  public function listNursingProcedure(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($request->id) {
        $testList = NursingProcedure::where('id', $request->id)->where('nursing_id', $user->uid)->where('is_deleted', '0')->first();
        $testList->image = asset('uploads/' . $testList->image);
      } else {
        $testList = NursingProcedure::where('nursing_id', $user->uid)->get();
      }
      return successResponse('List', $testList, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateNursingProcedure(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'title' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $data = $request->all();
        if ($data['id'] != '') {
          $nPInfo = NursingProcedure::where('nursing_id', $user->uid)->where('id', $data['id'])->first();
        } else {
          $nPInfo = new NursingProcedure;
        }
        $nPInfo->nursing_id = $user->uid;
        $nPInfo->title = $data['title'];
        $nPInfo->price = $data['price'];
        $nPInfo->status = $data['status'];

        $nPInfo->save();

        return successResponse('Successfull', $nPInfo, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateLabTestForLab(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'test_name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $data = $request->all();
        if ($data['id'] != '') {
          $labtest = Labtest::where('lab_id', $user->uid)->where('id', $data['id'])->first();
        } else {
          $labtest = new Labtest;
        }
        $labtest->lab_id = $user->uid;
        $labtest->category_id = $data['category_id'];
        $labtest->test_name = $data['test_name'];
        $labtest->price = $data['price'];
        $labtest->discount = $data['discount'];
        $labtest->prerequisite = $data['prerequisite'];
        $labtest->home_sample_collection = $data['home_sample_collection'];
        $labtest->report_home_delivery = $data['report_home_delivery'];
        $labtest->ambulance_available = $data['ambulance_available'];
        if($labtest->ambulance_available == 'Yes'){
          $labtest->ambulance_fee = $data['ambulance_fee'];
        }
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'laboratorist_image');
          if ($image['status']) {
            $labtest->image = $image['file_name'];
          }
        }

        $labtest->save();

        $test = Labtest_masterdb::where('title', $data['test_name'])->first();
        if (empty($test)) {
          $newTest = new Labtest_masterdb;
          $newTest->title = $data['test_name'];
          $newTest->is_approved = '0';
          $newTest->save();
        }

        return successResponse('Successfull', $labtest, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function labTestCategory(Request $request)
  {

    $user = Auth::guard('api');
    if ($user) {
      if ($request->id) {
        $testList = Labtestcategory::where('id', $request->id)->where('is_deleted', '0')->first();
        $testList->image = asset('category_image/' . $testList->image);
      } else {
        $testList = Labtestcategory::all();
      }


      return successResponse('Lab test category', $testList, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function labTestTop(Request $request)
  {
    $user = Auth::guard('api');
    if ($user) {
      $testList = Labtest::inRandomOrder()->limit(3)->get();

      return successResponse('Lab test', $testList, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function labList(Request $request)
  {

    $user = Auth::guard('api');
    if ($user) {
      if ($request->id) {
        $lab = Laboratorist::where('id', $request->id)->where('is_deleted', '0')->first();
      } else if ($request->slug) {
        $lab = Laboratorist::where('slug', $request->slug)->where('is_deleted', '0')->first();

        // $labInfo = User::where('uid', $lab->id)->where('type','Lab')->first();
        $lab->reviews = DB::table('reviews')
              ->select('user_id', DB::raw('COUNT(reviews.id) as total_reviews, AVG(stars) as avg_stars'))
              ->where('type', '=', 'Labtest')->where('user_id',  $lab->id)
              ->groupBy('user_id')
              ->first();

        $jdDays = json_decode($lab->days, true);
        $lab->days_string = implode(', ', $jdDays);

        $lab->tesList = Labtest::where('lab_id', $lab->id)->where('is_deleted', '0')->orderBy('test_name', 'ASC')->get();
        $lab->packageList = Labtestpackage::where('lab_id', $lab->id)->where('is_deleted', '0')->orderBy('package_name', 'ASC')->get();
        $pCount = count($lab->packageList);
        if ($pCount > 0) {
          $dArray = json_decode(json_encode($lab->tesList), true);
          for ($i = 0; $i < $pCount; $i++) {
            $tl = $lab->packageList[$i]['test_ids'];
            $lab->packageList[$i]['tList'] = array();
            $tl = json_decode($tl, true);
            if (is_array($tl)) {
              $tstArray = array();
              foreach ($tl as $value) {
                $key = array_search($value, array_column($dArray, 'id'));
                if ($key >= 0) {
                  $tstArray[] = $lab->tesList[$key];
                }
              }
              $lab->packageList[$i]['tList'] = $tstArray;
            }
          }
        }
      } else {
 
        if($request->sub_cat == 'Name'){ 
          $data = Laboratorist::where('slug', '!=', '')->where('is_deleted', '0')->where(function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
            $like = explode(' ', $request->search);
            foreach ($like as $value) {
              $query->orWhere('name', 'like', '%' . $value . '%');
            }
          })->limit(20)->get();
        } else if($request->sub_cat == 'Test'){ 
          $lb = Labtest::select('lab_id')->where(function ($query) use ($request) {
            $query->where('test_name', 'like', '%' . $request->search . '%');
            $like = explode(' ', $request->search);
            foreach ($like as $value) {
              $query->orWhere('test_name', 'like', '%' . $value . '%');
            }
          })->limit(20)->get();
          $sid = $lb->pluck('lab_id')->toArray(); 
          $data = Laboratorist::whereIn('id', $sid)->where('slug', '!=', '')->where('is_deleted', '0')->limit(6)->get();
        } else{
          $data = Laboratorist::where('slug', '!=', '')->where('is_deleted', '0')->limit(25)->get();
        }
        $lab = $data;
        // $response = array();
        for($i = 0; $i < count($lab); $i++){
          // $labInfo = User::where('uid', $lab[$i]['id'])->where('type','Lab')->first();
          // if(!empty($labInfo)){
            $lab[$i]['reviews'] = DB::table('reviews')
            ->select('user_id', DB::raw('COUNT(reviews.id) as total_reviews, FLOOR(AVG(stars)) as avg_stars'))
            ->where('type', '=', 'Labtest')->where('user_id',  $lab[$i]['id'])
            ->groupBy('user_id')
            ->first();
          // }else{
          //   $lab[$i]['reviews'] = [];
          // }
          
        }
      }


      return successResponse('Lab Staff List', $lab, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function nursingList(Request $request)
  {
    if ($request->id == '') {
      $query = Nursing::where('is_deleted', '0')->where('type','!=', '')->where('visit_charges','!=', 0); 
      if($request->q != ''){
        $query->where(function ($query) use ($request) {
          if($request->sub_cat == 'Name'){ 
            $query->where('name', 'like', '%' . $request->search . '%');
            $like = explode(' ', $request->search);
            foreach ($like as $value) {
              $query->orWhere('name', 'like', '%' . $value . '%');
            }
          }else if($request->sub_cat == 'Aya'){ 
            $query->where('type', 'like', '%Aya%');
          }else if($request->sub_cat == 'Nurse'){ 
            $query->where('type', 'like', '%Nurse%');
          }else if($request->sub_cat == 'Dai'){ 
            $query->where('type', 'like', '%Dai%');
          }else if($request->sub_cat == 'Physiotherapist'){ 
            $query->where('type', 'like', '%Physiotherapist%');
          }else if($request->sub_cat == 'Docter(BAMS)'){ 
            $query->where('type', 'like', '%Docter(BAMS)%');
          }else if($request->sub_cat == 'Docter(MBBS)'){ 
            $query->where('type', 'like', '%Docter(MBBS)%');
          }
        });
      }
      $info = $query->get();
      for($i = 0; $i < count($info); $i++){
        // $nrInfo = User::where('uid', $info[$i]['id'])->where('type','Nursing')->first();
        $info[$i]['reviews'] = DB::table('reviews')
                ->select('user_id', DB::raw('COUNT(reviews.id) as total_reviews, FLOOR(AVG(stars)) as avg_stars'))
                ->where('type', '=', 'Homecare')->where('user_id', $info[$i]['id'])
                ->groupBy('user_id')
                ->first();
      }

    } else {
      $info = Nursing::where('id', $request->id)->where('is_deleted', '0')->first();
      // $nrInfo = User::where('uid', $info['id'])->first();
      $info['reviews'] = DB::table('reviews')
                ->select('user_id', DB::raw('COUNT(reviews.id) as total_reviews, FLOOR(AVG(stars)) as avg_stars'))
                ->where('type', '=', 'Homecare')->where('user_id',   $info['id'])
                ->groupBy('user_id')
                ->first();
    }
    return successResponse('Nursing Info', $info, \Config::get('constants.status_code.SUCCESS'));
  }
  public function myNursingList(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      if ($request->id == '') {
        $info = Nursing::where('is_deleted', '0')->where('buero_id', $user->id)->get();
      } else {
        $info = Nursing::where('id', $request->id)->where('buero_id', $user->id)->where('is_deleted', '0')->first();
      }
      return successResponse('Nursing Info', $info, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function nursingInfoForSetup(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($user->type != 'Nursing') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }

      if($request->id == ''){
        $uid = $user->uid;
      }else{
        $uid = $request->id;
      }

      $info = Nursing::where('id', $uid)->where('is_deleted', '0')->first();

      if ($info == '') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      } else {

        $info->image = asset('uploads/' . $info->image);
        $info->banner = asset('uploads/' . $info->banner);
        $info->id_proof = asset('uploads/' . $info->id_proof);
        $info->degree = asset('uploads/' . $info->degree);
        $info->registration_certificate = asset('uploads/' . $info->registration_certificate);
        $info->cancel_cheque = asset('uploads/' . $info->cancel_cheque);
        $info->pan_image = asset('uploads/' . $info->pan_image);

        $user = User::where('uid',$uid)->where('type','Nursing')->first();
        $info->cp_name = $user->name;
        $info->c_email = $user->email;
        $info->c_mobile = $user->mobile;

        return successResponse('Nursing Info', array('data' => $info), \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateNursingInfoForSetupBk(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name_on_bank' => 'required',
        'bank_name' => 'required',
        'branch_name' => 'required',
        'ifsc' => 'required',
        'ac_no' => 'required',
        'ac_type' => 'required', 
        'pan_no' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {
        
        $uid = $request->id; 
        $nursing = Nursing::find($uid);
        $data = $request->all();

        $nursing->name_on_bank = $data['name_on_bank'];
        $nursing->bank_name = $data['bank_name'];
        $nursing->branch_name = $data['branch_name'];
        $nursing->ifsc = $data['ifsc'];
        $nursing->ac_no = $data['ac_no'];
        $nursing->ac_type = $data['ac_type'];
        if(@$data['micr_code'] != ''){
          $nursing->micr_code = $data['micr_code'];
        }
        
        $nursing->pan_no = $data['pan_no'];
        if ($data['cancel_cheque'] != '') {
          $cancel_cheque = uploadBase64File($data['cancel_cheque'], '', 'uploads');
          if ($cancel_cheque['status']) {
            $nursing->cancel_cheque = $cancel_cheque['file_name'];
          }
        }
        if ($data['pan_image'] != '') {
          $pan_image = uploadBase64File($data['pan_image'], '', 'uploads');
          if ($pan_image['status']) {
            $nursing->pan_image = $pan_image['file_name'];
          }
        }


        $nursing->save();

        return successResponse('Successfull', $nursing, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateNursingInfoForSetup(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {
         
        $data = $request->all();
        $isNew = false;
        $nursingInfo = Nursing::find($request->id);
        if(empty($nursingInfo)){
          $nursingInfo = new Nursing;
          $myInfo = Nursing::find($user->uid);
          $nursingInfo->buero_id = $myInfo->buero_id;
          $isNew = true;
        } 
       
        $nursingInfo->name = $data['name'];
        $nursingInfo->mobile = $data['mobile'];
        if(isset($data['regis_type'])){
          $nursingInfo->regis_type = $data['regis_type'];
        }
        if($nursingInfo->regis_type != 'Individual'){
          if($data['is_deleted'] == ''){
            $data['is_deleted'] = "0";
          }
          $nursingInfo->is_deleted = $data['is_deleted'];
        }
            if(isset($data['part_fill_time']) && $data['part_fill_time'] != '' && $data['part_fill_time'] != 'null'){
              $nursingInfo->part_fill_time = $data['part_fill_time'];
            }
            if(isset($data['work_hours']) && $data['work_hours'] != '' && $data['work_hours'] != 'null'){
              $nursingInfo->work_hours = $data['work_hours'];
            }
            if(isset($data['is_weekof_replacement']) && $data['is_weekof_replacement'] != '' && $data['is_weekof_replacement'] != 'null'){
              $nursingInfo->is_weekof_replacement = $data['is_weekof_replacement'];
            }
            
            if(isset($data['custom_remarks']) && $data['custom_remarks'] != '' && $data['custom_remarks'] != 'null'){
              $nursingInfo->custom_remarks = $data['custom_remarks'];
            }
            if(isset($data['visit_charges']) && $data['visit_charges'] != '' && $data['visit_charges'] != 'null'){
              $nursingInfo->visit_charges = $data['visit_charges'];
            }
            if(isset($data['per_hour_charges']) && $data['per_hour_charges'] != '' && $data['per_hour_charges'] != 'null'){
              $nursingInfo->per_hour_charges = $data['per_hour_charges'];
            }
            if(isset($data['per_days_charges']) && $data['per_days_charges'] != '' && $data['per_days_charges'] != 'null'){
              $nursingInfo->per_days_charges = $data['per_days_charges'];
            }
            if(isset($data['per_month_charges']) && $data['per_month_charges'] != '' && $data['per_month_charges'] != 'null'){
              $nursingInfo->per_month_charges = $data['per_month_charges'];
            }
            if(isset($data['experience']) && $data['experience'] != '' && $data['experience'] != 'null'){
              $nursingInfo->experience = $data['experience'];
            }
            if(isset($data['type']) && $data['type'] != '' && $data['type'] != 'null'){
              $nursingInfo->type = $data['type'];
            }
            if(isset($data['gender']) && $data['gender'] != '' && $data['gender'] != 'null'){
              $nursingInfo->gender = $data['gender'];
            }
            if(isset($data['qualification']) && $data['qualification'] != '' && $data['qualification'] != 'null'){
              $nursingInfo->qualification = $data['qualification'];
            }
            
            
          
        // }
        
        if(!empty($data['about'])){
          $nursingInfo->about = $data['about'];
        }
        

        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'uploads');
          if ($image['status']) {
            $nursingInfo->image = $image['file_name'];
          }
        }
        if ($data['banner'] != '') {
          $image = uploadBase64File($data['banner'], '', 'uploads');
          if ($image['status']) {
            $nursingInfo->banner = $image['file_name'];
          }
        }
        if ($data['registration_certificate'] != '') {
          $registration_certificate = uploadBase64File($data['registration_certificate'], '', 'uploads');
          if ($registration_certificate['status']) {
            $nursingInfo->registration_certificate = $registration_certificate['file_name'];
          }
        }
        if ($data['id_proof'] != '') {
          $id_proof = uploadBase64File($data['id_proof'], '', 'uploads');
          if ($id_proof['status']) {
            $nursingInfo->id_proof = $id_proof['file_name'];
          }
        }
        if ($data['degree'] != '') {
          $degree = uploadBase64File($data['degree'], '', 'uploads');
          if ($degree['status']) {
            $nursingInfo->degree = $degree['file_name'];
          }
        }

        $nursingInfo->save();
        if($nursingInfo->id != ''){
          if($isNew){
            $uData['uid'] = $nursingInfo->id;
            $uData['type'] = 'Nursing';
            $uData['is_verified'] = '1';
            $uData['name'] = $data['name'];
            $uData['email'] = strtolower($data['email']);
            $uData['mobile'] = $data['mobile'];
            $uData['password'] =  Hash::make('123456');
        
            $lastInserted = $this->createUser($uData);
          }
        }

        
        return successResponse('Successfull', $nursingInfo->id, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  
  public function updateNursingInfoForSetupCp(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {
       
        $uid = $request->id;
        $user = User::where('uid',$uid)->where('type','Nursing')->first();
        $data = $request->all();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        if ($data['password'] != '') {
          $user->password = Hash::make($data['password']);
        }

        $user->save();

        return successResponse('Successfull', $user, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function dealerInfoForSetup(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($user->type != 'Dealer') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }

      $info = Dealer::where('id', $user->uid)->where('is_deleted', '0')->first();

      if ($info == '') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      } else {

        $info->image = asset('uploads/' . $info->image);
        $info->banner = asset('uploads/' . $info->banner);
        $info->tin_proof = asset('uploads/' . $info->tin_proof);
        $info->gstin_proof = asset('uploads/' . $info->gstin_proof);
        $info->registration_certificate = asset('uploads/' . $info->registration_certificate);
        $info->cancel_cheque = asset('uploads/' . $info->cancel_cheque);
        $info->pan_image = asset('uploads/' . $info->pan_image);

        $info->owner_id = asset('uploads/' . $info->owner_id);
        $info->partner_id = asset('uploads/' . $info->partner_id);

        $user = User::find($user->id);
        $info->cp_name = $user->name;
        $info->c_email = $user->email;
        $info->c_mobile = $user->mobile;

        return successResponse('Dealer Info', array('data' => $info), \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateDealerInfoForSetupBk(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name_on_bank' => 'required',
        'bank_name' => 'required',
        'branch_name' => 'required',
        'ifsc' => 'required',
        'ac_no' => 'required',
        'ac_type' => 'required',
        'micr_code' => 'required',
        'pan_no' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $dealerInfo = Dealer::find($user->uid);
        $data = $request->all();

        $dealerInfo->name_on_bank = $data['name_on_bank'];
        $dealerInfo->bank_name = $data['bank_name'];
        $dealerInfo->branch_name = $data['branch_name'];
        $dealerInfo->ifsc = $data['ifsc'];
        $dealerInfo->ac_no = $data['ac_no'];
        $dealerInfo->ac_type = $data['ac_type'];
        $dealerInfo->micr_code = $data['micr_code'];
        $dealerInfo->pan_no = $data['pan_no'];
        if ($data['cancel_cheque'] != '') {
          $cancel_cheque = uploadBase64File($data['cancel_cheque'], '', 'uploads');
          if ($cancel_cheque['status']) {
            $dealerInfo->cancel_cheque = $cancel_cheque['file_name'];
          }
        }
        if ($data['pan_image'] != '') {
          $pan_image = uploadBase64File($data['pan_image'], '', 'uploads');
          if ($pan_image['status']) {
            $dealerInfo->pan_image = $pan_image['file_name'];
          }
        }


        $dealerInfo->save();

        return successResponse('Successfull', $dealerInfo, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateDealerInfoForSetup(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $dealerInfo = Dealer::find($user->uid);
        $data = $request->all();
        $dealerInfo->name = $data['name'];
        $dealerInfo->owner_name = $data['owner_name'];
        if($data['partner_name'] != ''){
          $dealerInfo->partner_name = $data['partner_name'];
        }
        
        $dealerInfo->about = $data['about'];
        $dealerInfo->gstin = $data['gstin'];
        $dealerInfo->tin = $data['tin'];

        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'uploads');
          if ($image['status']) {
            $dealerInfo->image = $image['file_name'];
          }
        }
        if ($data['banner'] != '') {
          $image = uploadBase64File($data['banner'], '', 'uploads');
          if ($image['status']) {
            $dealerInfo->banner = $image['file_name'];
          }
        }
        if ($data['registration_certificate'] != '') {
          $registration_certificate = uploadBase64File($data['registration_certificate'], '', 'uploads');
          if ($registration_certificate['status']) {
            $dealerInfo->registration_certificate = $registration_certificate['file_name'];
          }
        }
        if ($data['owner_id'] != '') {
          $owner_id = uploadBase64File($data['owner_id'], '', 'uploads');
          if ($owner_id['status']) {
            $dealerInfo->owner_id = $owner_id['file_name'];
          }
        }
        if ($data['partner_id'] != '') {
          $partner_id = uploadBase64File($data['partner_id'], '', 'uploads');
          if ($partner_id['status']) {
            $dealerInfo->partner_id = $partner_id['file_name'];
          }
        }
        if ($data['gstin_proof'] != '') {
          $gstin_proof = uploadBase64File($data['gstin_proof'], '', 'uploads');
          if ($gstin_proof['status']) {
            $dealerInfo->gstin_proof = $gstin_proof['file_name'];
          }
        }
        if ($data['tin_proof'] != '') {
          $tin_proof = uploadBase64File($data['tin_proof'], '', 'uploads');
          if ($tin_proof['status']) {
            $dealerInfo->tin_proof = $tin_proof['file_name'];
          }
        }

        $dealerInfo->save();

        return successResponse('Successfull', $dealerInfo, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateDealerInfoForSetupCp(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $user = User::find($user->id);
        $data = $request->all();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        if ($data['password'] != '') {
          $user->password = Hash::make($data['password']);
        }

        $user->save();

        return successResponse('Successfull', $user, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }


  public function ambInfoForSetup(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($user->type != 'Ambulance') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }

      $info = Ambulance::where('id', $user->uid)->where('is_deleted', '0')->first();

      if ($info == '') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      } else {

        $info->image = asset('uploads/' . $info->image);
        $info->banner = asset('uploads/' . $info->banner);

        $info->registration_certificate = asset('uploads/' . $info->registration_certificate);
        $info->cancel_cheque = asset('uploads/' . $info->cancel_cheque);
        $info->pan_image = asset('uploads/' . $info->pan_image);
        $info->aadhar_proof = asset('uploads/' . $info->aadhar_proof);
        $info->gstin_proof = asset('uploads/' . $info->gstin_proof);

        $user = User::find($user->id);
        $info->cp_name = $user->name;
        $info->c_email = $user->email;
        $info->c_mobile = $user->mobile;

        return successResponse('Ambulance Info', array('data' => $info), \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateAmbInfoForSetupBk(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name_on_bank' => 'required',
        'bank_name' => 'required',
        'branch_name' => 'required',
        'ifsc' => 'required',
        'ac_no' => 'required',
        'ac_type' => 'required',
        'micr_code' => 'required',
        'pan_no' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $dealerInfo = Ambulance::find($user->uid);
        $data = $request->all();

        $dealerInfo->name_on_bank = $data['name_on_bank'];
        $dealerInfo->bank_name = $data['bank_name'];
        $dealerInfo->branch_name = $data['branch_name'];
        $dealerInfo->ifsc = $data['ifsc'];
        $dealerInfo->ac_no = $data['ac_no'];
        $dealerInfo->ac_type = $data['ac_type'];
        $dealerInfo->micr_code = $data['micr_code'];
        $dealerInfo->pan_no = $data['pan_no'];
        if ($data['cancel_cheque'] != '') {
          $cancel_cheque = uploadBase64File($data['cancel_cheque'], '', 'uploads');
          if ($cancel_cheque['status']) {
            $dealerInfo->cancel_cheque = $cancel_cheque['file_name'];
          }
        }
        if ($data['pan_image'] != '') {
          $pan_image = uploadBase64File($data['pan_image'], '', 'uploads');
          if ($pan_image['status']) {
            $dealerInfo->pan_image = $pan_image['file_name'];
          }
        }


        $dealerInfo->save();

        return successResponse('Successfull', $dealerInfo, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function updateAmbInfoForSetup(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $Ambulance = Ambulance::find($user->uid);
        $data = $request->all();
        $Ambulance->name = $data['name'];
        $Ambulance->owner_name = $data['owner_name'];
        $Ambulance->public_number = $data['public_number'];
        $Ambulance->type_of_user = $data['type_of_user'];
        $Ambulance->about = $data['about'];
        $Ambulance->gstin = $data['gstin'];
        $Ambulance->aadhar = $data['aadhar'];

        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'uploads');
          if ($image['status']) {
            $Ambulance->image = $image['file_name'];
          }
        }
        if ($data['banner'] != '') {
          $image = uploadBase64File($data['banner'], '', 'uploads');
          if ($image['status']) {
            $Ambulance->banner = $image['file_name'];
          }
        }
        if ($data['registration_certificate'] != '') {
          $registration_certificate = uploadBase64File($data['registration_certificate'], '', 'uploads');
          if ($registration_certificate['status']) {
            $Ambulance->registration_certificate = $registration_certificate['file_name'];
          }
        }
        if ($data['aadhar_proof'] != '') {
          $aadhar_proof = uploadBase64File($data['aadhar_proof'], '', 'uploads');
          if ($aadhar_proof['status']) {
            $Ambulance->aadhar_proof = $aadhar_proof['file_name'];
          }
        }
        if ($data['aadhar_proof'] != '') {
          $aadhar_proof = uploadBase64File($data['aadhar_proof'], '', 'uploads');
          if ($aadhar_proof['status']) {
            $Ambulance->aadhar_proof = $aadhar_proof['file_name'];
          }
        }
        if ($data['gstin_proof'] != '') {
          $gstin_proof = uploadBase64File($data['gstin_proof'], '', 'uploads');
          if ($gstin_proof['status']) {
            $Ambulance->gstin_proof = $gstin_proof['file_name'];
          }
        }

        $Ambulance->save();

        return successResponse('Successfull', $Ambulance, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateAmbInfoForSetupCp(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $user = User::find($user->id);
        $data = $request->all();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        if ($data['password'] != '') {
          $user->password = Hash::make($data['password']);
        }

        $user->save();

        return successResponse('Successfull', $user, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function getMyExecutive(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) { 
      if ($request->id == '') {
        $info = DeliveryBoy::where('parent_id', $user->id)->where('is_deleted', '0')->get();
      } else {
        $info = DeliveryBoy::where('id', $request->id)->where('parent_id', $user->id)->first(); 
      }

      return successResponse('Executive Info',  $info, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function getMyAmbulanceList(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($user->type != 'Ambulance') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }

      if ($request->id == '') {
        $info = Ambulance_list::where('amb_id', $user->uid)->where('is_deleted', '0')->get();
      } else {
        $info = Ambulance_list::where('id', $request->id)->where('amb_id', $user->uid)->first();

        $info->regis_proof   = asset('uploads/' . $info->regis_proof);
        $info->img_1   = asset('uploads/' . $info->img_1);
        $info->img_2   = asset('uploads/' . $info->img_2);
        $info->img_3   = asset('uploads/' . $info->img_3);
        $info->img_4   = asset('uploads/' . $info->img_4);
        $info->img_5   = asset('uploads/' . $info->img_5);
        $info->img_6   = asset('uploads/' . $info->img_6);
      }

      return successResponse('Ambulance Info',  $info, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateExecutive(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'mobile' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {
 
        $data = $request->all();
        if ($data['id'] == '' || $data['id'] == 'undefined') {
          $dlby = new DeliveryBoy;
        } else {
          $dlby = DeliveryBoy::find($data['id']);
        }
        $dlby->name = $data['name'];
        $dlby->type = $data['type'];
        $dlby->mobile = $data['mobile'];
        $dlby->is_deleted = $data['is_deleted'];
        $dlby->parent_id = $user->id;
 
        $dlby->save();

        return successResponse('Successfull', $dlby, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateMyAmbulanceInfo(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'regis_no' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {


        $data = $request->all();
        if ($data['id'] == '' || $data['id'] == 'undefined') {
          $Ambulance = new Ambulance_list;
        } else {
          $Ambulance = Ambulance_list::find($data['id']);
        }
        $Ambulance->regis_no = $data['regis_no'];
        $Ambulance->ambulance_type = $data['ambulance_type'];
        $Ambulance->charges_per_day = $data['charges_per_day'];
        $Ambulance->discount_per_day = $data['discount_per_day'];
        $Ambulance->charges_per_km = $data['charges_per_km'];
        $Ambulance->discount_per_km = $data['discount_per_km'];
        $Ambulance->is_deleted = $data['is_deleted'];
        $Ambulance->amb_id = $user->uid;


        if ($data['regis_proof'] != '') {
          $image = uploadBase64File($data['regis_proof'], '', 'uploads');
          if ($image['status']) {
            $Ambulance->regis_proof = $image['file_name'];
          }
        }

        if ($data['img_1'] != '') {
          $image = uploadBase64File($data['img_1'], '', 'uploads');
          if ($image['status']) {
            $Ambulance->img_1 = $image['file_name'];
          }
        }
        if ($data['img_2'] != '') {
          $image = uploadBase64File($data['img_2'], '', 'uploads');
          if ($image['status']) {
            $Ambulance->img_2 = $image['file_name'];
          }
        }
        if ($data['img_3'] != '') {
          $image = uploadBase64File($data['img_3'], '', 'uploads');
          if ($image['status']) {
            $Ambulance->img_3 = $image['file_name'];
          }
        }
        if ($data['img_4'] != '') {
          $image = uploadBase64File($data['img_4'], '', 'uploads');
          if ($image['status']) {
            $Ambulance->img_4 = $image['file_name'];
          }
        }
        if ($data['img_5'] != '') {
          $image = uploadBase64File($data['img_5'], '', 'uploads');
          if ($image['status']) {
            $Ambulance->img_5 = $image['file_name'];
          }
        }
        if ($data['img_6'] != '') {
          $image = uploadBase64File($data['img_6'], '', 'uploads');
          if ($image['status']) {
            $Ambulance->img_6 = $image['file_name'];
          }
        }

        $Ambulance->save();

        return successResponse('Successfull', $Ambulance, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function getMyAmbulanceDriverList(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($user->type != 'Ambulance') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }

      if ($request->id == '') {
        $info = Ambulance_driver_list::where('amb_id', $user->uid)->where('is_deleted', '0')->get();
      } else {
        $info = Ambulance_driver_list::where('id', $request->id)->where('amb_id', $user->uid)->first();

        $info->image   = asset('uploads/' . $info->image);
        $info->liscence_photo   = asset('uploads/' . $info->liscence_photo);
      }

      return successResponse('Ambulance Info',  $info, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateMyAmbulanceDriverInfo(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'driver_name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {


        $data = $request->all();
        if ($data['id'] == '' || $data['id'] == 'undefined') {
          $Ambulance = new Ambulance_driver_list;
        } else {
          $Ambulance = Ambulance_driver_list::find($data['id']);
        }
        $Ambulance->driver_name = $data['driver_name'];
        $Ambulance->liscence_no = $data['liscence_no'];
        $Ambulance->mobile = $data['mobile'];
        $Ambulance->is_deleted = $data['is_deleted'];
        $Ambulance->amb_id = $user->uid;


        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'uploads');
          if ($image['status']) {
            $Ambulance->image = $image['file_name'];
          }
        }

        if ($data['liscence_photo'] != '') {
          $image = uploadBase64File($data['liscence_photo'], '', 'uploads');
          if ($image['status']) {
            $Ambulance->liscence_photo = $image['file_name'];
          }
        }

        $Ambulance->save();

        return successResponse('Successfull', $Ambulance, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }



  public function parmacyInfoForSetup(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($user->type != 'Pharmacy') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }

      $info = Pharmacy::where('id', $user->uid)->where('is_deleted', '0')->first();

      if ($info == '') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      } else {

        $info->image = asset('pharmacy_image/' . $info->image);
        $info->drug_liscence_file = asset('pharmacy_image/' . $info->drug_liscence_file);
        $info->cancel_cheque = asset('pharmacy_image/' . $info->cancel_cheque);
        $info->pan_image = asset('pharmacy_image/' . $info->pan_image);
        $info->gstin_certificate = asset('pharmacy_image/' . $info->gstin_certificate);
        $info->owner_id = asset('pharmacy_image/' . $info->owner_id);
        $info->partner_id = asset('pharmacy_image/' . $info->partner_id);
        $info->pharmacist_regis_upload = asset('pharmacy_image/' . $info->pharmacist_regis_upload);

        $user = User::find($user->id);
        $info->cp_name = $user->name;
        $info->c_email = $user->email;
        $info->c_mobile = $user->mobile;

        return successResponse('Lab Info', array('data' => $info), \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function updatePharmacyInfoForSetupBk(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name_on_bank' => 'required',
        'bank_name' => 'required',
        'branch_name' => 'required',
        'ifsc' => 'required',
        'ac_no' => 'required',
        'ac_type' => 'required',
        'micr_code' => 'required',
        'pan_no' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $pharmacyInfo = Pharmacy::find($user->uid);
        $data = $request->all();

        $pharmacyInfo->name_on_bank = $data['name_on_bank'];
        $pharmacyInfo->bank_name = $data['bank_name'];
        $pharmacyInfo->branch_name = $data['branch_name'];
        $pharmacyInfo->ifsc = $data['ifsc'];
        $pharmacyInfo->ac_no = $data['ac_no'];
        $pharmacyInfo->ac_type = $data['ac_type'];
        $pharmacyInfo->micr_code = $data['micr_code'];
        $pharmacyInfo->pan_no = $data['pan_no'];
        if ($data['cancel_cheque'] != '') {
          $cancel_cheque = uploadBase64File($data['cancel_cheque'], '', 'pharmacy_image');
          if ($cancel_cheque['status']) {
            $pharmacyInfo->cancel_cheque = $cancel_cheque['file_name'];
          }
        }
        if ($data['pan_image'] != '') {
          $pan_image = uploadBase64File($data['pan_image'], '', 'pharmacy_image');
          if ($pan_image['status']) {
            $pharmacyInfo->pan_image = $pan_image['file_name'];
          }
        }


        $pharmacyInfo->save();

        return successResponse('Successfull', $pharmacyInfo, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updatePharmacyInfoForSetup(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $pharmacyInfo = Pharmacy::find($user->uid);
        $data = $request->all();
        $pharmacyInfo->name = $data['name'];
        $pharmacyInfo->delivery_charges_if_less = $data['delivery_charges_if_less'];
        $pharmacyInfo->delivery_charges = $data['delivery_charges'];
        $pharmacyInfo->drug_liscence_valid_upto = $data['drug_liscence_valid_upto'];
        $pharmacyInfo->drug_liscence_number = $data['drug_liscence_number'];
        $pharmacyInfo->owner_name = $data['owner_name'];
        if($data['partner_name'] != ''){
          $pharmacyInfo->partner_name = $data['partner_name'];
        }
        $pharmacyInfo->pharmacist_name = $data['pharmacist_name'];
        $pharmacyInfo->pharmacist_regis_no = $data['pharmacist_regis_no'];
        $pharmacyInfo->gstin = $data['gstin'];
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'pharmacy_image');
          if ($image['status']) {
            $pharmacyInfo->image = $image['file_name'];
          }
        }
        if ($data['drug_liscence_file'] != '') {
          $drug_liscence_file = uploadBase64File($data['drug_liscence_file'], '', 'pharmacy_image');
          if ($drug_liscence_file['status']) {
            $pharmacyInfo->drug_liscence_file = $drug_liscence_file['file_name'];
          }
        }
        if ($data['owner_id'] != '') {
          $owner_id = uploadBase64File($data['owner_id'], '', 'pharmacy_image');
          if ($owner_id['status']) {
            $pharmacyInfo->owner_id = $owner_id['file_name'];
          }
        }
        if ($data['partner_id'] != '') {
          $partner_id = uploadBase64File($data['partner_id'], '', 'pharmacy_image');
          if ($partner_id['status']) {
            $pharmacyInfo->partner_id = $partner_id['file_name'];
          }
        }
        if ($data['pharmacist_regis_upload'] != '') {
          $pharmacist_regis_upload = uploadBase64File($data['pharmacist_regis_upload'], '', 'pharmacy_image');
          if ($pharmacist_regis_upload['status']) {
            $pharmacyInfo->pharmacist_regis_upload = $pharmacist_regis_upload['file_name'];
          }
        }
        if ($data['gstin_certificate'] != '') {
          $gstin_certificate = uploadBase64File($data['gstin_certificate'], '', 'pharmacy_image');
          if ($gstin_certificate['status']) {
            $pharmacyInfo->gstin_certificate = $gstin_certificate['file_name'];
          }
        }

        $pharmacyInfo->save();

        return successResponse('Successfull', $pharmacyInfo, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updatePharmacyInfoForSetupCp(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $user = User::find($user->id);
        $data = $request->all();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        if ($data['password'] != '') {
          $user->password = Hash::make($data['password']);
        }

        $user->save();

        return successResponse('Successfull', $user, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }



  public function labInfoForSetup(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($user->type != 'Lab') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }

      $info = Laboratorist::where('id', $user->uid)->where('is_deleted', '0')->first();

      if ($info == '') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      } else {

        $info->image = asset('laboratorist_image/' . $info->image);
        $info->owner_id = asset('laboratorist_image/' . $info->owner_id);
        $info->registration_file = asset('laboratorist_image/' . $info->registration_file);
        $info->cancel_cheque = asset('laboratorist_image/' . $info->cancel_cheque);
        $info->pan_image = asset('laboratorist_image/' . $info->pan_image);

        if($info->accredition_details != ''){
          $ac = explode(",",$info->accredition_details);
          if(count($ac) > 0){
            foreach($ac as $val){
              $v = AccreditionCertificate::where('parent_id', $user->id)->where('doc_name', $val)->orderBy('id', 'DESC')->first();
              if(!empty($v) && @$v->proof != ''){
                $info[$val] = asset('laboratorist_image/' . @$v->proof);
              }else{
                $info[$val] = '';
              } 
            }
          }
        } 
        
        $user = User::find($user->id);
        $info->cp_name = $user->name;
        $info->c_email = $user->email;
        $info->c_mobile = $user->mobile;

        return successResponse('Lab Info', array('data' => $info), \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function updateLabInfoForSetup(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $lab = Laboratorist::find($user->uid);
        $data = $request->all();
        $lab->name = $data['name'];
        $lab->phone_no = $data['phone_no'];
        $lab->h_c_fee = $data['h_c_fee'];
        $lab->h_c_fee_apply_before = $data['h_c_fee_apply_before'];
        $lab->r_d_fee = $data['r_d_fee'];
        $lab->r_d_fee_apply_before = $data['r_d_fee_apply_before'];
        $lab->ambulance_fee = $data['ambulance_fee'];
        $lab->owner_name = $data['owner_name'];

        $lab->about = $data['about'];

        $lab->days = $data['days'];

        $lab->registration_detail = $data['registration_detail'];
        $lab->accredition_details = $data['accredition_details'];
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'laboratorist_image');
          if ($image['status']) {
            $lab->image = $image['file_name'];
          }
        }
        if ($data['owner_id'] != '') {
          $owner_id = uploadBase64File($data['owner_id'], '', 'laboratorist_image');
          if ($owner_id['status']) {
            $lab->owner_id = $owner_id['file_name'];
          }
        }
        if ($data['registration_file'] != '') {
          $registration_file = uploadBase64File($data['registration_file'], '', 'laboratorist_image');
          if ($registration_file['status']) {
            $lab->registration_file = $registration_file['file_name'];
          }
        }
        $acValue = explode(',',$data['accredition_details']);
        $acCtf = json_decode($data['accredition_certificate'],true);
        foreach($acCtf as $val){
          $accredition_certificate = uploadBase64File($val['value'], '', 'laboratorist_image');
          if ($accredition_certificate['status']) {
            $ac = new AccreditionCertificate;
            $ac->parent_id = $user->id;
            $ac->doc_name = $val['key'];
            $ac->proof = $accredition_certificate['file_name'];  
            $ac->save();
            if(@count($acValue) > 0){
              AccreditionCertificate::where('parent_id', $user->id)->whereNotIn('doc_name',$acValue)->update( array('is_deleted'=>'1') ); 
            } 
          }
         
        } 

        $lab->save();

        return successResponse('Successfull', $acValue, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateLabInfoForSetupCp(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $user = User::find($user->id);
        $data = $request->all();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        if ($data['password'] != '') {
          $user->password = Hash::make($data['password']);
        }

        $user->save();

        return successResponse('Successfull', $user, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateLabInfoForSetupBk(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name_on_bank' => 'required',
        'bank_name' => 'required',
        'branch_name' => 'required',
        'ifsc' => 'required',
        'ac_no' => 'required',
        'ac_type' => 'required',
        'micr_code' => 'required',
        'pan_no' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $labInfo = Laboratorist::find($user->uid);
        $data = $request->all();

        $labInfo->name_on_bank = $data['name_on_bank'];
        $labInfo->bank_name = $data['bank_name'];
        $labInfo->branch_name = $data['branch_name'];
        $labInfo->ifsc = $data['ifsc'];
        $labInfo->ac_no = $data['ac_no'];
        $labInfo->ac_type = $data['ac_type'];
        $labInfo->micr_code = $data['micr_code'];
        $labInfo->pan_no = $data['pan_no'];
        if ($data['cancel_cheque'] != '') {
          $cancel_cheque = uploadBase64File($data['cancel_cheque'], '', 'laboratorist_image');
          if ($cancel_cheque['status']) {
            $labInfo->cancel_cheque = $cancel_cheque['file_name'];
          }
        }
        if ($data['pan_image'] != '') {
          $pan_image = uploadBase64File($data['pan_image'], '', 'laboratorist_image');
          if ($pan_image['status']) {
            $labInfo->pan_image = $pan_image['file_name'];
          }
        }


        $labInfo->save();

        return successResponse('Successfull', $labInfo, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function ambulanceBookingForm(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'service_ambulance_id' => 'required',
        'ambulance_id' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $bb = new AmbulanceBooking;
        $data = $request->all();
        $bb->user_id = $user->id;
        $bb->name = $data['name']; 
        $bb->mobile = $data['mobile'];
        $bb->address = $data['address'];
        $bb->drop_address = $data['drop_address'];
        $bb->service_ambulance_id = $data['service_ambulance_id'];
        $bb->booking_type = $data['booking_type'];
        $bb->booking_for = $data['booking_for'];
        $bb->date = $data['date']; 
        $bb->ambulance_id = $data['ambulance_id'];
        $bb->save();

        return successResponse('Successfull', $bb, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('Login first', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function bbDonationForm(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $bb = new BloodDoner;
        $data = $request->all();
        $bb->user_id = $user->id;
        $bb->name = $data['name'];
        $bb->blood_group = urldecode($data['blood_group']);
        $bb->mobile = $data['mobile'];
        $bb->email = $data['email'];
        $bb->date = $data['date'];
        $bb->available_in_emergency = $data['available_in_emergency'];
        $bb->bloodbank_id = $data['bloodbank_id'];
        $bb->save();

        return successResponse('Successfull', $bb, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('Login first', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function ambulanceList(Request $request)
  {
 
      if ($request->id) {
        $bbList = Ambulance::where('id', $request->id)->where('is_deleted', '0')->first(); 
      } else if ($request->slug) {
        $bbList = Ambulance::where('slug', $request->slug)->where('is_deleted', '0')->with('ambulance_list')->first();
        $docInfo = User::where('uid', $bbList['id'])->where('type','Ambulance')->first();
        $bbList['reviews'] = DB::table('reviews')
                  ->select('user_id', DB::raw('COUNT(reviews.id) as total_reviews, FLOOR(AVG(stars)) as avg_stars'))
                  ->where('type', '=', 'Ambulance')->where('user_id', $docInfo['uid'])
                  ->groupBy('user_id')
                  ->first();

      } else {
        $query = Ambulance::where('slug', '!=', '')->where('is_deleted', '0')->where('type_of_user', '!=', ''); 
        if($request->q != '' && $request->type == ''){
          
        if($request->searchBy == 'AmbulanceType'){
          if($request->q != ''){
            $q = $request->q;
            $query->whereIn('id', function($query) use ($q){
              $query->select('amb_id')
              ->from(with(new Ambulance_list)->getTable())
              ->where('ambulance_type',  'like', '%' . $q . '%')
              ->where('is_deleted', '0');
            });
            } 
          }
          if($request->searchBy == 'Ambulance'){
            $query->where('name',  'like', '%' . $request->q . '%');
          }
        }else if($request->q != '' && $request->type != ''){
          $ambIds = Ambulance_list::where('ambulance_type', 'like', '%' . $request->type . '%')
                ->groupBy('amb_id')
                ->pluck('amb_id')
                ->toArray();

            $query->whereIn('id', $ambIds);
        } 
        $bbList = $query->get();
        for($i = 0; $i < count($bbList); $i++){
          $docInfo = User::where('uid', $bbList[$i]['id'])->where('type','Ambulance')->first();
          if(!empty($docInfo)){
            $bbList[$i]['reviews'] = DB::table('reviews')
            ->select('user_id', DB::raw('COUNT(reviews.id) as total_reviews, FLOOR(AVG(stars)) as avg_stars'))
            ->where('type', '=', 'Ambulance')->where('user_id',  $docInfo['uid'])
            ->groupBy('user_id')
            ->first();
          }else{
            $bbList[$i]['reviews'] = [];
          }
          
        }
      }
 
      return successResponse('Ambulance List', $bbList, \Config::get('constants.status_code.SUCCESS'));
    
  }
  public function bbList(Request $request)
  {

     
      if ($request->id) {
        $bbList = Bloodbank::where('id', $request->id)->where('is_deleted', '0')->first();
        if($bbList->days != ''){
          $jdDays = json_decode($bbList->days, true);
          $bbList->days_string = implode(', ', $jdDays);
        }else{
          $bbList->days_string = '';
        }
        
      } else if ($request->slug) {
        $bbList = Bloodbank::where('slug', $request->slug)->where('is_deleted', '0')->first();
        if($bbList->days != ''){
          $jdDays = json_decode($bbList->days, true);
          $bbList->days_string = implode(', ', $jdDays);
        }else{
          $bbList->days_string = '';
        }
        
        $bbList->stock = Bloodbankstock::where('bloodbank_id', $bbList->id)->get();
        $rvInfo = User::where('uid', $bbList->id)->first();
        $bbList->reviews = DB::table('reviews')
                  ->select('user_id', DB::raw('COUNT(reviews.id) as total_reviews, AVG(stars) as avg_stars'))
                  ->where('type', '=', 'Bloodbank')->where('user_id',  $bbList->id)
                  ->groupBy('user_id')
                  ->first();
      } else {
        $query = Bloodbank::where('slug', '!=', '')->where('is_deleted', '0'); 
        if($request->sub_cat == 'Name'){ 
          $query->where('name', 'like', '%' . $request->search . '%');
          $like = explode(' ', $request->search);
          foreach ($like as $value) {
            $query->orWhere('name', 'like', '%' . $value . '%');
          }
        }else if($request->sub_cat == 'Component'){
          $sp = Bloodbankstock::select('bloodbank_id')->where('component_name', 'like', '%' . $request->search . '%')->limit(20)->get();
          $sid = $sp->pluck('bloodbank_id')->toArray();  
          if(count($sid) > 0){
            $query->whereIn('id',$sid);
         }else{
           $query->where('id','=','not found');
         }  
        }
        $bbList = $query->get();

        for($i = 0; $i < count($bbList); $i++){
          $rvInfo = User::where('uid', $bbList[$i]['id'])->first();
          if(!empty($rvInfo)){
            $bbList[$i]['reviews'] = DB::table('reviews')
            ->select('user_id', DB::raw('COUNT(reviews.id) as total_reviews, FLOOR(AVG(stars)) as avg_stars'))
            ->where('type', '=', 'Bloodbank')->where('user_id',  $bbList[$i]['id'])
            ->groupBy('user_id')
            ->first();
          }else{
            $bbList[$i]['reviews'] = [];
          }
         
        }
      }


      return successResponse('Bloodbank List', $bbList, \Config::get('constants.status_code.SUCCESS'));
     
  }
  public function bloodbankInfoForSetup(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($user->type != 'Bloodbank') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }

      $info = Bloodbank::where('id', $user->uid)->where('is_deleted', '0')->first();

      if ($info == '') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      } else {

        $info->image = asset('hospital_image/' . $info->image);
        $info->registration_file = asset('hospital_image/' . $info->registration_file);
        $info->liscence_file = asset('hospital_image/' . $info->liscence_file);

        $user = User::find($user->id);
        $info->cp_name = $user->name;
        $info->c_email = $user->email;
        $info->c_mobile = $user->mobile;

        return successResponse('Bloodbank Info', array('data' => $info), \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function updateBloodbankInfoForSetup(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);
      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {
        $bb = Bloodbank::find($user->uid);
        $data = $request->all();
        $bb->name = $data['name'];
        $bb->owner_name = $data['owner_name'];
        $bb->public_number = $data['public_number'];
        $bb->about = $data['about'];
        $bb->days = $data['days'];
        $bb->liscence_no = $data['liscence_no'];
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'hospital_image');
          if ($image['status']) {
            $bb->image = $image['file_name'];
          }
        }
        if ($data['liscence_file'] != '') {
          $liscence_file = uploadBase64File($data['liscence_file'], '', 'hospital_image');
          if ($liscence_file['status']) {
            $bb->liscence_file = $liscence_file['file_name'];
          }
        }

        $bb->save();

        return successResponse('Successfull', $bb, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateBloodbankInfoForSetupCp(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $user = User::find($user->id);
        $data = $request->all();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        if ($data['password'] != '') {
          $user->password = Hash::make($data['password']);
        }

        $user->save();

        return successResponse('Successfull', $user, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function bbDonationReq(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
     
      if ($user->type == 'Bloodbank') {
        $info = BloodDoner::where('bloodbank_id', $user->uid)->where('is_deleted', '0')->orderBy('id', 'DESC')->get();
      }else{
        $info = BloodDoner::select('blood_doners.*','bloodbanks.address','bloodbanks.city','bloodbanks.pincode','bloodbanks.country', 'rv.stars', 'rv.comment')->leftJoin("reviews as rv",  function($q) {
          $q->on('rv.service_id', '=', 'blood_doners.id');
          $q->where('rv.type', '=', 'Bloodbank', 'and');
        })->where('blood_doners.user_id', $user->id)->join("bloodbanks", "bloodbanks.id", "=", "blood_doners.bloodbank_id")->where('blood_doners.is_deleted', '0')->orderBy('blood_doners.id', 'DESC')->get();
      }

      return successResponse('Bloodbank stock Info',  $info, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function getBloodbankStock(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($user->type != 'Bloodbank') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
      $data = $request->all();
      if ($data['id'] != '') {
        $info = Bloodbankstock::where('bloodbank_id', $user->uid)->where('id', $data['id'])->where('is_deleted', '0')->first();
      } else {
        $info = Bloodbankstock::where('bloodbank_id', $user->uid)->where('is_deleted', '0')->get();
      }

      $componenet = BloodbankComponent::get();
      return successResponse('Bloodbank stock Info', array('data' => $info, 'component' => $componenet), \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function bbDonationComplete(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'id' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $data = $request->all();
        $dInfo = BloodDoner::where('id', $data['id'])->where('bloodbank_id', $user->uid)->first();
        $dInfo->is_donated = '1';
        $dInfo->save();

        return successResponse('Successfull', $dInfo, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateBloodbankStock(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'component_name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {


        $data = $request->all();
        if ($data['id'] == '') {
          $stock = new Bloodbankstock;
        } else {
          $stock = Bloodbankstock::find($data['id']);
        }
        $stock->bloodbank_id = $user->uid;
        $stock->component_name = urldecode($data['component_name']);
        $stock->avialablity = $data['avialablity'];

        $stock->available_unit = $data['available_unit'];

        $stock->save();

        return successResponse('Successfull', $stock, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function getDealerProductList(Request $request)
  {

    
      $data = $request->all();
      if ($data['id'] != '') {
        $info = DealerProduct::where('id', $data['id'])->where('is_deleted', '0')->first();
        $info->image = asset('uploads/' . $info->image);
        $info->image_2 = asset('uploads/' . $info->image_2);
        $info->image_3 = asset('uploads/' . $info->image_3);
        $info->image_4 = asset('uploads/' . $info->image_4);
      } else if (@$data['q'] != '') {
        $search = DealerProduct::where('item_name', 'like', '%' . $data['q'] . '%');
        $s = explode(' ', $data['q']);
        foreach ($s as $value) {
          if ($value != '') {
            $search->orWhere('item_name', 'like', '%' . $value . '%');
          }
        }
        $info = $search->where('is_deleted', '0')->where('status', '1')->limit(30)->get();
      } else {
        $query = DealerProduct::where('is_deleted', '0');
        $user = Auth::guard('api')->user();
        if ($user) {
          if ($user->type == 'Dealer') {
            $query->where('dealer_id', $user->id);
          }
          if ($user->type == 'Pharmacy') {
            $query->where('dealer_id', $user->id);
          }
        }
        $info = $query->get();
      }

      return successResponse('Dealer stock Info', $info, \Config::get('constants.status_code.SUCCESS'));
     
  }
  
  public function updateDealerProductInfo(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'item_name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {


        $data = $request->all();
        if ($data['id'] == '') {
          $stock = new DealerProduct;
        } else {
          $stock = DealerProduct::find($data['id']);
        }
        $stock->dealer_id = $user->id;
        $stock->item_name = urldecode($data['item_name']);
        $stock->company = $data['company'];
        $stock->pack_size = $data['pack_size'];
        if($data['manufacturer_address'] != ''){
          $stock->manufacturer_address = $data['manufacturer_address'];
        }
        if($data['category_id'] != ''){
          $stock->category_id = $data['category_id'];
        }
        if( $data['is_prescription_required'] != ''){
          $stock->is_prescription_required = $data['is_prescription_required'];
        }
         
        $stock->description = $data['description'];
        $stock->mrp = $data['mrp'];
        $stock->discount = $data['discount'];
        $stock->delivery_charges = $data['delivery_charges'];
        $stock->is_rent = $data['is_rent'];
        if ($stock->is_rent == 1) {
          $stock->rent_per_day = $data['rent_per_day'];
          $stock->security_for_rent = $data['security_for_rent'];
          $stock->delivery_charges_for_rent = $data['delivery_charges_for_rent'];
        }

        $stock->status = $data['status'];
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'uploads');
          if ($image['status']) {
            $stock->image = $image['file_name'];
          }
        }
        if ($data['image_2'] != '') {
          $image = uploadBase64File($data['image_2'], '', 'uploads');
          if ($image['status']) {
            $stock->image_2 = $image['file_name'];
          }
        }
        if ($data['image_3'] != '') {
          $image = uploadBase64File($data['image_3'], '', 'uploads');
          if ($image['status']) {
            $stock->image_3 = $image['file_name'];
          }
        }
        if ($data['image_4'] != '') {
          $image = uploadBase64File($data['image_4'], '', 'uploads');
          if ($image['status']) {
            $stock->image_4 = $image['file_name'];
          }
        }

        $stock->save();

        return successResponse('Successfull', $stock, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
}
