<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Hash;
use App\Models\Facilities;
use App\Models\Empanelments;
use App\Models\Specialities;
use App\Models\Procedures;
use App\Models\User;
use App\Models\Hospital;
use Illuminate\Support\Facades\DB;

class HospitalController extends Controller
{
  public function hospitalList(Request $request, $id = null)
  {

    $user = Auth::guard('api');
    if ($user) {
      if ($request->id) {
        $hospital = Hospital::where('id', $request->id)->first();
        $fc = json_decode($hospital->facilities_avialable, true);
        if(count($fc) > 0){
          $hospital->facilities = Facilities::where('hospital_id', $fc)->get();
        }else{
          $hospital->facilities = [];
        }

        $emp = json_decode($hospital->empanelments, true);
        if(count($emp) > 0){
          $hospital->empanelments = Empanelments::where('id', $emp)->get();
        }else{
          $hospital->empanelments = [];
        }

        $spid = json_decode($hospital->specialities_id, true);
        if(count($spid) > 0){
          $hospital->specialities = Specialities::whereIn('id', $spid)->get();
        }else{
          $hospital->specialities = [];
        }
        $prc = json_decode($hospital->procedures_id, true);
        if(count($spid) > 0){
          $hospital->procedures = Procedures::where('id', $prc)->get();
        }else{
          $hospital->procedures = [];
        }
      } else if ($request->slug) {
        $hospital = Hospital::where('slug', $request->slug)->first();
        $fc = json_decode($hospital->facilities_avialable, true);
        if($hospital->facilities_avialable != '' && $hospital->facilities_avialable != ']'){
          if(count($fc) > 0){
            $hospital->facilities = Facilities::whereIn('id', $fc)->get();
          }else{
            $hospital->facilities = [];
          }
        }else{
          $hospital->facilities = [];
        }
        
        if($hospital->empanelments != '' && $hospital->empanelments != []){
          $emp = json_decode($hospital->empanelments, true);
          if(count($emp) > 0){
            $hospital->empanelments = Empanelments::whereIn('id', $emp)->get();
          }else{
            $hospital->empanelments = [];
          }
        }else{
          $hospital->empanelments = [];
        }
        
        if($hospital->specialities_id != '' && $hospital->specialities_id != '[]'){
          $spid = json_decode($hospital->specialities_id, true);
          if(count($spid) > 0){
            $hospital->specialities = Specialities::whereIn('id', $spid)->get();
          }else{
            $hospital->specialities = [];
          }
        }else{
          $hospital->specialities = [];
        }
        if($hospital->procedures_id != '' && $hospital->procedures_id != '[]'){
          $prc = json_decode($hospital->procedures_id, true);
          if(count($prc) > 0){
            $hospital->procedures = Procedures::whereIn('id', $prc)->get();
          }else{
            $hospital->procedures = [];
          }
        }else{
          $hospital->procedures = [];
        }
        $docInfo = Doctor::where('hospital_id', $hospital->id)->get();
        $hospital->reviews = DB::table('reviews')
                ->select('user_id', DB::raw('COUNT(reviews.id) as total_reviews, AVG(stars) as avg_stars'))
                ->where('type', '=', 'Appointments')->whereIn('user_id', $docInfo->pluck('id'))
                ->groupBy('user_id')
                ->first();

      } else {
        $query = Hospital::where('slug', '!=', '')->where('is_deleted', '0');
        if($request->sub_cat == 'Name'){
          $query->where('name', 'like', '%' . $request->search . '%');
          $like = explode(' ', $request->search);
          foreach ($like as $value) {
            $query->orWhere('name', 'like', '%' . $value . '%');
          }
        }else if($request->sub_cat == 'Specility'){
          $sp = Specialities::select('id')->where('speciality_name', 'like', '%' . $request->search . '%')->limit(20)->get();
          $sid = $sp->pluck('id')->toArray();
          $query->whereNotNull('specialities_id')->where('specialities_id','!=','');
         
          if(count($sid) > 0){
             $query->where(function($qx) use ($sid) {
              foreach ($sid as $id) {
                $qx->orWhere(function($q) use ($id) {
                    $q->orWhere('specialities_id', 'like', '%,' . $id . '%');
                    $q->orWhere('specialities_id', 'like', '%' . $id . ',%');
                    $q->orWhere('specialities_id', 'like', '%[' . $id . ']%');
                });  
              }
            }); 
          }else{
            $query->where('specialities_id','=','not found');
          } 
        }else if($request->sub_cat == 'Facility'){
          $sp = Facilities::select('id')->where('title', 'like', '%' . $request->search . '%')->limit(20)->get();
          $sid = $sp->pluck('id')->toArray();
          $query->whereNotNull('facilities_avialable')->where('facilities_avialable','!=','');
         
          if(count($sid) > 0){
             $query->where(function($qx) use ($sid) {
              foreach ($sid as $id) {
                $qx->orWhere(function($q) use ($id) {
                    $q->orWhere('facilities_avialable', 'like', '%,' . $id . '%');
                    $q->orWhere('facilities_avialable', 'like', '%' . $id . ',%');
                    $q->orWhere('facilities_avialable', 'like', '%[' . $id . ']%');
                });  
              }
            }); 
          }else{
            $query->where('facilities_avialable','=','not found');
          } 
        }else if($request->sub_cat == 'Empanelments'){
          $sp = Empanelments::select('id')->where('title', 'like', '%' . $request->search . '%')->limit(20)->get();
          $sid = $sp->pluck('id')->toArray();
          $query->whereNotNull('empanelments')->where('empanelments','!=','');
         
          if(count($sid) > 0){
             $query->where(function($qx) use ($sid) {
              foreach ($sid as $id) {
                $qx->orWhere(function($q) use ($id) {
                    $q->orWhere('empanelments', 'like', '%,' . $id . '%');
                    $q->orWhere('empanelments', 'like', '%' . $id . ',%');
                    $q->orWhere('empanelments', 'like', '%[' . $id . ']%');
                });  
              }
            }); 
          }else{
            $query->where('empanelments','=','not found');
          }  
        }
        $hospital = $query->get();
      }

      return successResponse('Hospital List', $hospital, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function hospInfoForSetup(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($user->type != 'Hospital') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }

      $facilities = Facilities::where('is_approved', '1')->get();
      $empanelments = Empanelments::where('is_approved', '1')->get();
      $specialities = Specialities::where('is_approved', '1')->get();
      $procedures = Procedures::where('is_approved', '1')->get();
      $info = Hospital::where('id', $user->uid)->where('is_deleted', '0')->first();


      if ($info == '') {
        return failResponse('Invalid Request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      } else {

        $info->image = asset('hospital_image/' . $info->image);
        $info->registration_file = asset('hospital_image/' . $info->registration_file);
        $info->accredition_certificate = asset('hospital_image/' . $info->accredition_certificate);

        $user = User::find($user->id);
        $info->c_name = $user->name;
        $info->c_email = $user->email;
        $info->c_mobile = $user->mobile;

        return successResponse('Doctor Info', array('data' => $info, 'facilities' => $facilities, 'empanelments' => $empanelments, 'specialities' => $specialities, 'procedures' => $procedures), \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  private function createNew($value, $type)
  {
    if ($type == 'facilities') {
      $data = new Facilities;
      $data->title = $value;
    } else if ($type == 'empanelments') {
      $data = new Empanelments;
      $data->title = $value;
    } else if ($type == 'procedures') {
      $data = new Procedures;
      $data->name = $value;
    } else if ($type == 'speciality') {
      $data = new Specialities;
      $data->speciality_name = $value;
      $data->specialization_id = null;
    }
    $data->is_approved = '0';
    $data->save();
    return $data->id;
  }
  public function updateHospInfoForSetup(Request $request)
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

        $hospital = Hospital::find($user->uid);
        $data = $request->all();
        $hospital->name = $data['name'];
        $hospital->type = $data['type'];
        $hospital->phone_no = $data['phone_no'];
        $hospital->beds_quantity = $data['beds_quantity'];
        $hospital->about = $data['about'];
        $hospital->registration_details = $data['registration_details'];
        $hospital->accredition_details = $data['accredition_details'];

        $facList = json_decode($data['facilities_avialable'], true);
        for ($i = 0; $i < count($facList); $i++) {
          if (is_string($facList[$i])) {
            $facList[$i] = $this->createNew($facList[$i], 'facilities');
          }
        }
        $hospital->facilities_avialable = json_encode($facList);

        $empList = json_decode($data['empanelments'], true);
        for ($i = 0; $i < count($empList); $i++) {
          if (is_string($empList[$i])) {
            $empList[$i] = $this->createNew($empList[$i], 'empanelments');
          }
        }
        $hospital->empanelments = json_encode($empList);

        $spltyList = json_decode($data['specialities_id'], true);
        for ($i = 0; $i < count($spltyList); $i++) {
          if (is_string($spltyList[$i])) {
            $spltyList[$i] = $this->createNew($spltyList[$i], 'speciality');
          }
        }
        $hospital->specialities_id = json_encode($spltyList);

        $proList = json_decode($data['procedures_id'], true);
        for ($i = 0; $i < count($proList); $i++) {
          if (is_string($proList[$i])) {
            $proList[$i] = $this->createNew($proList[$i], 'procedures');
          }
        }
        $hospital->procedures_id = json_encode($proList);
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'hospital_image');
          if ($image['status']) {
            $hospital->image = $image['file_name'];
          }
        }
        if ($data['registration_file'] != '') {
          $registration_file = uploadBase64File($data['registration_file'], '', 'hospital_image');
          if ($registration_file['status']) {
            $hospital->registration_file = $registration_file['file_name'];
          }
        }
        if ($data['accredition_certificate'] != '') {
          $accredition_certificate = uploadBase64File($data['accredition_certificate'], '', 'hospital_image');
          if ($accredition_certificate['status']) {
            $hospital->accredition_certificate = $accredition_certificate['file_name'];
          }
        }

        $hospital->save();

        return successResponse('Successfull', $hospital, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateHospInfoForSetupCp(Request $request)
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
}
