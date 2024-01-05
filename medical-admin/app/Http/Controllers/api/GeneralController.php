<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Bloodbank;
use Illuminate\Http\Request;
use App\Models\DesignationList;
use App\Models\Medical_counsiling;
use App\Models\BloodbankComponent;
use App\Models\Labtest_masterdb;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\User;
use App\Models\Laboratorist;
use App\Models\Pharmacy;
use App\Models\Nursing;
use App\Models\Dealer;
use App\Models\Ambulance;
use App\Models\Ambulance_list;
use App\Models\AmbulanceType;
use App\Models\Bloodbankstock;
use App\Models\Customer;
use App\Models\DignosisList;
use App\Models\ChatReport;
use App\Models\DealerProduct;
use App\Models\Empanelments;
use App\Models\Facilities;
use App\Models\IllnessList;
use App\Models\Labtest;
use App\Models\ListingDiscountList;
use App\Models\Product;
use App\Models\Review;
use App\Models\ServicePayment;
use App\Models\ServicePaymentHistory;
use App\Models\Specialities;
use App\Models\SymptomsList;
use App\Models\TreatmentAndSurgeryList;
use Auth;
use DB;
use Validator;

class GeneralController extends Controller
{
  public function autoSuggestionOld(Request $request)
  {
    $cat = $request->cat; 
    if($cat == 'Hospital'){ 
      $data = Hospital::where(function ($query) use ($request) {
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
      })->limit(6)->get();
    }else if($cat == 'Doctor'){
      $data = Doctor::where(function ($query) use ($request) {
        if($request->sub_cat == 'Name'){ 
          $query->where('full_name', 'like', '%' . $request->search . '%');
          $like = explode(' ', $request->search);
          foreach ($like as $value) {
            $query->orWhere('full_name', 'like', '%' . $value . '%');
          }
        }else if($request->sub_cat == 'Specility'){
          $sp = Specialities::select('id')->where('speciality_name', 'like', '%' . $request->search . '%')->limit(6)->get();
          $sid = $sp->pluck('id')->toArray();
          $query->whereRaw('json_contains(specialities_id,  \'[' . implode(',',$sid).  ']\')');
          if(count($sid) > 0){
            foreach ($sid as $id) { 
              $query->orWhereRaw('json_contains(specialities_id, \'[' . $id . ']\')');
            }
          } 
        }else if($request->sub_cat == 'Symptoms'){
          $sp = SymptomsList::select('id')->where('title', 'like', '%' . $request->search . '%')->limit(6)->get();
          $sid = $sp->pluck('id')->toArray();
          $query->whereNotNull('symptom_i_see')->where('symptom_i_see','!=','');
         
          if(count($sid) > 0){
             $query->where(function($qx) use ($sid) {
              foreach ($sid as $id) {
                $qx->orWhere(function($q) use ($id) {
                    $q->orWhere('symptom_i_see', 'like', '%,' . $id . '%');
                    $q->orWhere('symptom_i_see', 'like', '%' . $id . ',%');
                    $q->orWhere('symptom_i_see', 'like', '%[' . $id . ']%');
                });  
              }
            }); 
          }else{
            $query->where('symptom_i_see','=','not found');
          }
        }else if($request->sub_cat == 'Diseases'){
          $sp = IllnessList::select('id')->where('title', 'like', '%' . $request->search . '%')->limit(6)->get();
          $sid = $sp->pluck('id')->toArray(); 
          $query->whereNotNull('deasies_i_treat')->where('deasies_i_treat','!=','');
          if(count($sid) > 0){
            $query->where(function($qx) use ($sid) {
             foreach ($sid as $id) {
               $qx->orWhere(function($q) use ($id) {
                   $q->orWhere('deasies_i_treat', 'like', '%,' . $id . '%');
                   $q->orWhere('deasies_i_treat', 'like', '%' . $id . ',%');
                   $q->orWhere('deasies_i_treat', 'like', '%[' . $id . ']%');
               });  
             }
           }); 
         }else{
           $query->where('deasies_i_treat','=','not found');
         }
        }else if($request->sub_cat == 'Treatment'){
          $sp = TreatmentAndSurgeryList::select('id')->where('title', 'like', '%' . $request->search . '%')->limit(6)->get();
          $sid = $sp->pluck('id')->toArray(); 
          $query->whereNotNull('treatment_and_surgery')->where('treatment_and_surgery','!=','');
          if(count($sid) > 0){
            $query->where(function($qx) use ($sid) {
             foreach ($sid as $id) {
               $qx->orWhere(function($q) use ($id) {
                   $q->orWhere('treatment_and_surgery', 'like', '%,' . $id . '%');
                   $q->orWhere('treatment_and_surgery', 'like', '%' . $id . ',%');
                   $q->orWhere('treatment_and_surgery', 'like', '%[' . $id . ']%');
               });  
             }
           }); 
         }else{
           $query->where('treatment_and_surgery','=','not found');
         }
        }
        
      })->limit(6)->get();
    }else if($cat == 'Lab'){

      if($request->sub_cat == 'Name'){ 
        $data = Laboratorist::where(function ($query) use ($request) {
          $query->where('name', 'like', '%' . $request->search . '%');
          $like = explode(' ', $request->search);
          foreach ($like as $value) {
            $query->orWhere('name', 'like', '%' . $value . '%');
          }
        })->limit(6)->get();
      } else if($request->sub_cat == 'Test'){ 
        $lb = Labtest::select('lab_id')->where(function ($query) use ($request) {
          $query->where('test_name', 'like', '%' . $request->search . '%');
          $like = explode(' ', $request->search);
          foreach ($like as $value) {
            $query->orWhere('test_name', 'like', '%' . $value . '%');
          }
        })->limit(6)->get();
        $sid = $lb->pluck('lab_id')->toArray(); 
        $data = Laboratorist::whereIn('id', $sid)->limit(6)->get();
      } 
    }else if($cat == 'Homecare'){
      $data = Nursing::where(function ($query) use ($request) {
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
      })->limit(6)->get();
    }else if($cat == 'Ambulance'){
      $data = Ambulance::where(function ($query) use ($request) {
        if($request->sub_cat == 'Name'){ 
          $query->where('name', 'like', '%' . $request->search . '%');
          $like = explode(' ', $request->search);
          foreach ($like as $value) {
            $query->orWhere('name', 'like', '%' . $value . '%');
          }
        }else if($request->sub_cat == 'Type'){ 
          $sp = Ambulance_list::select('amb_id')->where('ambulance_type', 'like', '%' . $request->search . '%')->limit(20)->get();
          $sid = $sp->pluck('amb_id')->toArray();  
          if(count($sid) > 0){
            $query->whereIn('id',$sid);
         }else{
           $query->where('id','=','not found');
         } 
        }
      })->limit(6)->get();
    }else if($cat == 'Bloodbank'){
      $data = Bloodbank::where(function ($query) use ($request) {
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
      })->limit(6)->get();
    }else if($cat == 'Medicine'){
      $data = Product::where(function ($query) use ($request) { 
        $like = explode(' ', $request->search);
        foreach ($like as $value) { 
          $query->orWhere('title', 'like', '%' . $value . '%');
          $query->orWhere('variant_name', 'like', '%' . $value . '%');
        } 
        $query->whereNotNull('title')->where('title','!=','')->where('title','!=','null')->where('is_deleted','0');
      })->limit(6)->get();
    }else if($cat == 'Equipment'){
      $data = DealerProduct::where(function ($query) use ($request) {
        $query->where('item_name', 'like', '%' . $request->search . '%');
        $like = explode(' ', $request->search);
        foreach ($like as $value) {
          $query->orWhere('item_name', 'like', '%' . $value . '%');
          $query->orWhere('description', 'like', '%' . $value . '%');
        } 
      })->limit(6)->get();
    }
      
    return successResponse('List', $data, \Config::get('constants.status_code.SUCCESS'));
    
  }

  public function autoSuggestion(Request $request)
  {
    $cat = $request->cat; 
    if($cat == 'Hospital'){ 
     
        if($request->sub_cat == 'Name'){
          $data = Hospital::where(function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
            $like = explode(' ', $request->search);
            foreach ($like as $value) {
              $query->orWhere('name', 'like', '%' . $value . '%');
            }
          })->limit(6)->get();
        }else if($request->sub_cat == 'Specility'){
          $data = Specialities::where('speciality_name', 'like', '%' . $request->search . '%')->limit(8)->get();
        }else if($request->sub_cat == 'Facility'){
          $data = Facilities::where('title', 'like', '%' . $request->search . '%')->limit(8)->get();
        }else if($request->sub_cat == 'Empanelments'){
          $data = Empanelments::where('title', 'like', '%' . $request->search . '%')->limit(8)->get();  
        }
    }else if($cat == 'Doctor'){
        if($request->sub_cat == 'Name'){ 
          $data = Doctor::where(function ($query) use ($request) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
            $like = explode(' ', $request->search);
            foreach ($like as $value) {
              $query->orWhere('full_name', 'like', '%' . $value . '%');
            }
          })->limit(6)->get();
        }else if($request->sub_cat == 'Specility'){
          $data = Specialities::where('speciality_name', 'like', '%' . $request->search . '%')->limit(6)->get();
           
        }else if($request->sub_cat == 'Symptoms'){
          $data = SymptomsList::where('title', 'like', '%' . $request->search . '%')->limit(6)->get();
          
        }else if($request->sub_cat == 'Diseases'){
          $data = IllnessList::where('title', 'like', '%' . $request->search . '%')->limit(6)->get();
        }else if($request->sub_cat == 'Treatment'){
          $data = TreatmentAndSurgeryList::where('title', 'like', '%' . $request->search . '%')->limit(6)->get();
      
        } 
    }else if($cat == 'Lab'){

      if($request->sub_cat == 'Name'){ 
        $data = Laboratorist::where(function ($query) use ($request) {
          $query->where('name', 'like', '%' . $request->search . '%');
          $like = explode(' ', $request->search);
          foreach ($like as $value) {
            $query->orWhere('name', 'like', '%' . $value . '%');
          }
        })->limit(6)->get();
      } else if($request->sub_cat == 'Test'){ 
        $data = Labtest::where(function ($query) use ($request) {
          $query->where('test_name', 'like', '%' . $request->search . '%');
          $like = explode(' ', $request->search);
          foreach ($like as $value) {
            $query->orWhere('test_name', 'like', '%' . $value . '%');
          }
        })->limit(6)->get(); 
      } 
    }else if($cat == 'Homecare'){
      $data = Nursing::where(function ($query) use ($request) {
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
      })->limit(6)->get();
    }else if($cat == 'Ambulance'){
        if($request->sub_cat == 'Name'){ 
          $data = Ambulance::where(function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
            $like = explode(' ', $request->search);
            foreach ($like as $value) {
              $query->orWhere('name', 'like', '%' . $value . '%');
            }
          })->limit(6)->get();
        }else if($request->sub_cat == 'Type'){ 
          $data = Ambulance_list::where('ambulance_type', 'like', '%' . $request->search . '%')->limit(20)->get(); 
        }
    }else if($cat == 'Bloodbank'){
      
        if($request->sub_cat == 'Name'){ 
          $data = Bloodbank::where(function ($query) use ($request) {
          $query->where('name', 'like', '%' . $request->search . '%');
          $like = explode(' ', $request->search);
          foreach ($like as $value) {
            $query->orWhere('name', 'like', '%' . $value . '%');
          }
        })->limit(6)->get();
        }else if($request->sub_cat == 'Component'){
          $data = Bloodbankstock::where('component_name', 'like', '%' . $request->search . '%')->limit(6)->get();
        }
      
    }else if($cat == 'Medicine'){
      $data = Product::where(function ($query) use ($request) { 
        $like = explode(' ', $request->search);
        foreach ($like as $value) { 
          $query->orWhere('title', 'like', '%' . $value . '%');
          $query->orWhere('variant_name', 'like', '%' . $value . '%');
        } 
        $query->whereNotNull('title')->where('title','!=','')->where('title','!=','null')->where('is_deleted','0');
      })->limit(6)->get();
    }else if($cat == 'Equipment'){
      $data = DealerProduct::where(function ($query) use ($request) {
        $query->where('item_name', 'like', '%' . $request->search . '%');
        $like = explode(' ', $request->search);
        foreach ($like as $value) {
          $query->orWhere('item_name', 'like', '%' . $value . '%');
          $query->orWhere('description', 'like', '%' . $value . '%');
        } 
      })->limit(6)->get();
    }
      
    return successResponse('List', $data, \Config::get('constants.status_code.SUCCESS'));
    
  }
  public function reportChat(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $isExist = ChatReport::where('apn_id',$request->apnid)->first();
      if(empty($isExist)){
        $r = new ChatReport;
        $r->message = $request->message;
        $r->apn_id = $request->apnid;
        $r->user_id = $user->uid;
        $r->reported_by = $user->type;
        $r->status = 'Pending';
        $r->save();
        return successResponse('Reported sucessfully', [], \Config::get('constants.status_code.SUCCESS'));
      }else{
        return successResponse('Already reported please wait for action.', [], \Config::get('constants.status_code.SUCCESS'));
      }
    }  else {
      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

     
  public function getLabtestMaster(Request $request)
  {
    $q = Labtest::where(function ($query) use ($request) {
      $query->where('test_name', 'like', '%' . $request->title . '%');
      
      $like = explode(' ', $request->title);
      
      foreach ($like as $value) {
          $query->orWhere('test_name', 'like', '%' . $value . '%');
      }
    });
    $data = $q->where('is_approved', '1')->limit(6)->get();

    return successResponse('List', $data, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getBBComponent(Request $request)
  {
    $data = BloodbankComponent::get();

    return successResponse('List', $data, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getDesignation(Request $request)
  {
    $d = DesignationList::where('title', 'like', '%' . $request->title . '%');

    $like = explode(' ', $request->title);
    foreach ($like as $value) {
      $d->orWhere('title', 'like', '%' . $value . '%');
    }
    $data = $d->where('is_approved', '1')->limit(150)->get();

    return successResponse('List', $data, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getListingChargesInfo(Request $request)
  {
    $data = ServicePayment::where('id', $request->id)->first();
    return successResponse('List', $data, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getServiceInfo(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      
      $query = ServicePaymentHistory::where('user_id',$user->id)->where('service_id', $request->service_id)->orderBy('id', 'desc');

      if($request->type == 'day'){
        $query->whereDate('end_date', '>=', now());
      }

      $data = $query->first();
      if(empty($data)){ 
        if($user->type == 'Nursing'){
          $buero = Nursing::where('id',$user->uid)->first();
          $query = ServicePaymentHistory::where('user_id',@$buero->buero_id)->where('service_id', $request->service_id)->orderBy('id', 'desc');

          if($request->type == 'day'){
            $query->whereDate('end_date', '>=', now());
          }
    
          $data = $query->first();
          if(empty($data)){ 
            return successResponse('Not paid', [], \Config::get('constants.status_code.SUCCESS'));
          }else{
            return successResponse('Data', $data, \Config::get('constants.status_code.SUCCESS'));
          }
        }else if($user->type == 'Doctor'){
          $doc = Doctor::where('id',$user->uid)->first();
          if($doc->hospital_id != ''){
            $query = ServicePaymentHistory::where('user_id',(int)$doc->hospital_id)->where('service_id', 2)->orderBy('id', 'desc');

            if($request->type == 'day'){
              $query->whereDate('end_date', '>=', now());
            }

            $data = $query->first();
            if(empty($data)){ 
              return successResponse('Not paid', $doc, \Config::get('constants.status_code.SUCCESS'));
            } else{
              return successResponse('Data', $data, \Config::get('constants.status_code.SUCCESS'));
            }                     
          }else{
            return successResponse('Not paid', [], \Config::get('constants.status_code.SUCCESS'));
          }
        }else{
          return successResponse('Not paid', [], \Config::get('constants.status_code.SUCCESS'));
        }
       
      }else{
        return successResponse('Data', $data, \Config::get('constants.status_code.SUCCESS'));
      }
    }  else {
      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function validateCoupon(Request $request)
  {
    $query = ListingDiscountList::where('is_deleted', '0')->where('title', $request->code); 
    
    $cList = $query->first();
    return successResponse('Ambulance type list', $cList, \Config::get('constants.status_code.SUCCESS'));
      
  }
  public function getAmbType(Request $request)
  {
    $query = AmbulanceType::where('is_deleted', '0'); 
    
    $ambList = $query->get();
    return successResponse('Info', $ambList, \Config::get('constants.status_code.SUCCESS'));
      
  }
  public function getSingleReviews(Request $request)
  {
    $query = Review::where('type', $request->type);
    
    if($request->user_id != '' && $request->user_id != 'undefined'){
      $query->where('user_id', $request->user_id);
    } 
    if($request->service_id != ''){
      $query->where('service_id', $request->service_id);
    } 
    
    $review = $query->first();
    return successResponse('Review list', $review, \Config::get('constants.status_code.SUCCESS'));
      
  }
  public function getAllReviews(Request $request)
  {
    $query = Review::where('type', $request->type);
    
    if($request->id != ''){
      if($request->type == 'Appointments'){
        $docInfo = User::where('uid', $request->id)->where('type','Doctor')->first();
        $request->id = $docInfo['id'];
      }
     
      $query->where('user_id', $request->id);
    } 
    
    $review = $query->get();
    return successResponse('Review list', $review, \Config::get('constants.status_code.SUCCESS'));
      
  }
  public function reviewSubmitAction(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $query = Review::where('customer_id',$user->id)->where('user_id',$request->user_id)->where('service_id',$request->service_id)->where('type',$request->type)->first();
      if(empty($query)){
        $query = new Review;
      }
      
      $query->customer_id = $user->id;
      $query->user_id = $request->user_id;
      $query->stars = $request->star;
      if($request->review != ''){
        $query->comment = $request->review;
      } 
      $query->service_id = $request->service_id;
      $query->type = $request->type;
      $query->save();
       
      if(!isset($query->id)){ 
        return successResponse('Something went wrong', '', \Config::get('constants.status_code.SUCCESS'));
      }else{
        return successResponse('Review submitted', $query, \Config::get('constants.status_code.SUCCESS'));
      }
    }  else {
      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function getDignosisList(Request $request)
  {
    $d = DignosisList::where('title', 'like', '%' . $request->title . '%');

    $like = explode(' ', $request->title);
    foreach ($like as $value) {
      $d->orWhere('title', 'like', '%' . $value . '%');
    }
    $data = $d->where('is_approved', '1')->get();

    return successResponse('Info', $data, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getMedicalCounsiling(Request $request)
  {
    $d = Medical_counsiling::where('title', 'like', '%' . $request->title . '%');

    $like = explode(' ', $request->title);
    foreach ($like as $value) {
      $d->orWhere('title', 'like', '%' . $value . '%');
    }
    $data = $d->where('is_approved', '1')->get();

    return successResponse('Doctor Info', $data, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getAddressInfo(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $dataArray = array();
      if ($user->type == 'Doctor' && $request->updating_for == 'doctor') {
        $doc = Doctor::where('id', $user->uid)->first();
        if ($request->address_type == 'clinic') {
          $dataArray['address'] = @$doc->address;
          $dataArray['city'] = @$doc->city;
          $dataArray['pincode'] = @$doc->pincode;
          $dataArray['country'] = @$doc->country;
          $dataArray['latitude'] = @$doc->latitude;
          $dataArray['longitude'] = @$doc->longitude;
        } else {
          $dataArray['address_2'] = @$doc->address_2;
          $dataArray['city_2'] = @$doc->city_2;
          $dataArray['pincode_2'] = @$doc->pincode_2;
          $dataArray['country_2'] = @$doc->country_2;
          $dataArray['latitude_2'] = @$doc->latitude_2;
          $dataArray['longitude_2'] = @$doc->longitude_2;
        }
      } else if ($user->type == 'Hospital' && $request->updating_for == 'hospital') {
        $hospital = Hospital::where('id', $user->uid)->first();
        $dataArray['address'] = @$hospital->address;
        $dataArray['city'] = @$hospital->city;
        $dataArray['pincode'] = @$hospital->pincode;
        $dataArray['country'] = @$hospital->country;
        $dataArray['latitude'] = @$hospital->latitude;
        $dataArray['longitude'] = @$hospital->longitude;
      } else if ($user->type == 'Lab' && $request->updating_for == 'lab') {
        $lab = Laboratorist::where('id', $user->uid)->first();
        $dataArray['address'] = @$lab->address;
        $dataArray['city'] = @$lab->city;
        $dataArray['pincode'] = @$lab->pincode;
        $dataArray['country'] = @$lab->country;
        $dataArray['latitude'] = @$lab->latitude;
        $dataArray['longitude'] = @$lab->longitude;
      } else if ($user->type == 'Pharmacy' && $request->updating_for == 'pharmacy') {
        $pharmacy = Pharmacy::where('id', $user->uid)->first();
        $dataArray['address'] = @$pharmacy->address;
        $dataArray['city'] = @$pharmacy->city;
        $dataArray['pincode'] = @$pharmacy->pincode;
        $dataArray['country'] = @$pharmacy->country;
        $dataArray['latitude'] = @$pharmacy->latitude;
        $dataArray['longitude'] = @$pharmacy->longitude;
      } else if ($user->type == 'Bloodbank' && $request->updating_for == 'bloodbank') {
        $bloodbank = Bloodbank::where('id', $user->uid)->first();
        $dataArray['address'] = @$bloodbank->address;
        $dataArray['city'] = @$bloodbank->city;
        $dataArray['pincode'] = @$bloodbank->pincode;
        $dataArray['country'] = @$bloodbank->country;
        $dataArray['latitude'] = @$bloodbank->latitude;
        $dataArray['longitude'] = @$bloodbank->longitude;
      } else if ($user->type == 'Nursing' && $request->updating_for == 'nursing') {
        $nursing = Nursing::where('id', $user->uid)->first();
        $dataArray['address'] = @$nursing->address;
        $dataArray['city'] = @$nursing->city;
        $dataArray['pincode'] = @$nursing->pincode;
        $dataArray['country'] = @$nursing->country;
        $dataArray['latitude'] = @$nursing->latitude;
        $dataArray['longitude'] = @$nursing->longitude;
      } else if ($user->type == 'Dealer' && $request->updating_for == 'dealer') {
        $dealer = Dealer::where('id', $user->uid)->first();
        $dataArray['address'] = @$dealer->address;
        $dataArray['city'] = @$dealer->city;
        $dataArray['pincode'] = @$dealer->pincode;
        $dataArray['country'] = @$dealer->country;
        $dataArray['latitude'] = @$dealer->latitude;
        $dataArray['longitude'] = @$dealer->longitude;
      } else if ($user->type == 'Ambulance' && $request->updating_for == 'ambulance') {
        $dealer = Ambulance::where('id', $user->uid)->first();
        $dataArray['address'] = @$dealer->address;
        $dataArray['city'] = @$dealer->city;
        $dataArray['pincode'] = @$dealer->pincode;
        $dataArray['country'] = @$dealer->country;
        $dataArray['latitude'] = @$dealer->latitude;
        $dataArray['longitude'] = @$dealer->longitude;
      } else if ($user->type == 'User' && $request->updating_for == 'customer') {
        $customer = Customer::where('id', $user->uid)->first();
        $dataArray['address'] = @$customer->address;
        $dataArray['city'] = @$customer->city;
        $dataArray['pincode'] = @$customer->pincode;
        $dataArray['country'] = @$customer->country;
        $dataArray['latitude'] = @$customer->latitude;
        $dataArray['longitude'] = @$customer->longitude;
      }
      return successResponse('Address', $dataArray, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function updateAddressInfo(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      if ($user->type == 'Doctor' && $request->updating_for == 'doctor') {
        $doc = Doctor::where('id', $user->uid)->first();
        if ($request->address_type == 'clinic') {
          $doc->address = $request->address;
          $doc->city = $request->city;
          $doc->pincode = $request->pincode;
          $doc->country = $request->country;
          $doc->latitude = $request->latitude;
          $doc->longitude = $request->longitude;
          $doc->save();
        } else {
          $doc->address_2 = $request->address;
          $doc->city_2 = $request->city;
          $doc->pincode_2 = $request->pincode;
          $doc->country_2 = $request->country;
          $doc->latitude_2 = $request->latitude;
          $doc->longitude_2 = $request->longitude;
          $doc->save();
        }
      } else if ($user->type == 'Hospital' && $request->updating_for == 'hospital') {
        $hospital = Hospital::where('id', $user->uid)->first();
        $hospital->address = $request->address;
        $hospital->city = $request->city;
        $hospital->pincode = $request->pincode;
        $hospital->country = $request->country;
        $hospital->latitude = $request->latitude;
        $hospital->longitude = $request->longitude;
        $hospital->save();
      } else if ($user->type == 'Lab' && $request->updating_for == 'lab') {
        $lab = Laboratorist::where('id', $user->uid)->first();
        $lab->address = $request->address;
        $lab->city = $request->city;
        $lab->pincode = $request->pincode;
        $lab->country = $request->country;
        $lab->latitude = $request->latitude;
        $lab->longitude = $request->longitude;
        $lab->save();
      } else if ($user->type == 'Pharmacy' && $request->updating_for == 'pharmacy') {
        $pharmacy = Pharmacy::where('id', $user->uid)->first();
        $pharmacy->address = $request->address;
        $pharmacy->city = $request->city;
        $pharmacy->pincode = $request->pincode;
        $pharmacy->country = $request->country;
        $pharmacy->latitude = $request->latitude;
        $pharmacy->longitude = $request->longitude;
        $pharmacy->save();
      } else if ($user->type == 'Bloodbank' && $request->updating_for == 'bloodbank') {
        $bloodbank = Bloodbank::where('id', $user->uid)->first();
        $bloodbank->address = $request->address;
        $bloodbank->city = $request->city;
        $bloodbank->pincode = $request->pincode;
        $bloodbank->country = $request->country;
        $bloodbank->latitude = $request->latitude;
        $bloodbank->longitude = $request->longitude;
        $bloodbank->save();
      } else if ($user->type == 'Nursing' && $request->updating_for == 'nursing') {
        $nursing = Nursing::where('id', $user->uid)->first();
        $nursing->address = $request->address;
        $nursing->city = $request->city;
        $nursing->pincode = $request->pincode;
        $nursing->country = $request->country;
        $nursing->latitude = $request->latitude;
        $nursing->longitude = $request->longitude;
        $nursing->save();
      } else if ($user->type == 'Dealer' && $request->updating_for == 'dealer') {
        $dealer = Dealer::where('id', $user->uid)->first();
        $dealer->address = $request->address;
        $dealer->city = $request->city;
        $dealer->pincode = $request->pincode;
        $dealer->country = $request->country;
        $dealer->latitude = $request->latitude;
        $dealer->longitude = $request->longitude;
        $dealer->save();
      } else if ($user->type == 'Ambulance' && $request->updating_for == 'ambulance') {
        $dealer = Ambulance::where('id', $user->uid)->first();
        $dealer->address = $request->address;
        $dealer->city = $request->city;
        $dealer->pincode = $request->pincode;
        $dealer->country = $request->country;
        $dealer->latitude = $request->latitude;
        $dealer->longitude = $request->longitude;
        $dealer->save();
      } else if ($user->type == 'User' && $request->updating_for == 'customer') {
        $customer = Customer::where('id', $user->uid)->first();
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->pincode = $request->pincode;
        $customer->country = $request->country;
        $customer->latitude = $request->latitude;
        $customer->longitude = $request->longitude;
        $customer->save();
      }
      return successResponse('Address updated', [], \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
}
