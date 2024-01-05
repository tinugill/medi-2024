<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use App\Models\LabtestBookings;
use App\Models\BuyCart;
use App\Models\DealerProduct;
use App\Models\Treatment;
use App\Models\Product;
use App\Models\Price;
use App\Models\DealerProductPurchase;
use App\Models\HomeCareRequest;
use App\Models\PincodeMap;
use App\Models\DoctorComment;
use App\Models\DoctorMedicineAdvice;
use App\Models\LabBookingInfoList;
use App\Models\Pharmacy;
use Auth;
use DB;
use Validator;

class AppointmentController extends Controller
{
  public function cartInfo(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {

      $cart    = json_decode($request->cart, true);
      $cartItem = array();
      $responseArray = array();
      if (is_array($cart)) {
        $total = 0;
        $discount = 0;
        $otherCharges = 0;
        $prescription_required = false;
        $isAddressRequired = false;
        $isPackageAdded = false;
        $productTotal = 0;
        $firstPharmacyId = 0;
        foreach ($cart as $d) {
          if ($d['type'] == 'product') {
            $product = Product::where('id', $d['id'])->where('is_deleted', '0')->first();
            if (!empty($product)) {
              $total = ($product['mrp'] * $d['qty']) + $total;
              $dis =  $product['mrp']*($product['discount']/100);
              
              $discount = ($dis * $d['qty']) + $discount;
              $pArray['val'] = $product;
              if ($pArray['val']->prescription_required == 'Yes') {
                $prescription_required = true;
              }
              $pArray['val']->mrp = $product['mrp']  * $d['qty'];
              $pArray['val']->discount = $dis * $d['qty'];
              $pArray['val']->price_id = $product['id'];
              $pArray['val']->qty = $d['qty'];
              $pArray['val']->req_id = $d['id'];
              $pArray['type'] = 'product';
              $cartItem[] = $pArray;
              $isAddressRequired = true;
              $productTotal += ($pArray['val']->mrp - $pArray['val']->discount);
              $firstPharmacyId = $product['pharmacy_id'];
            }
          } else if ($d['type'] == 'treatment') {
            $isPackageAdded = true;
            $treatment = Treatment::where('id', $d['id'])->where('is_deleted', '0')->first();
            $pArray['type'] = 'treatment';
            $pArray['val'] = $treatment;
            $pArray['val']->qty = $d['qty'];
            $pArray['val']->req_id = $d['id'];
            $cartItem[] = $pArray;
            $total = ($treatment['charges_in_rs']  * $d['qty']) + $total;
            $discount = ((($treatment['discount_in_rs']/100) *$treatment['charges_in_rs']) * $d['qty']) + $discount;
          } else if ($d['type'] == 'equp') {
            $info = DealerProduct::where('id', $d['id'])->where('is_deleted', '0')->first();
            $pArray['type'] = 'equp';
            $pArray['val'] = $info;
            $pArray['val']->qty = $d['qty'];
            $pArray['val']->req_id = $d['id'];
            $cartItem[] = $pArray;
            $total = ($info['mrp']  * $d['qty']) + $total;
            $discount = ((($info['discount']/100) * $info['mrp']) *  $d['qty']) + $discount;
            $otherCharges = ($info['delivery_charges'] * $d['qty']) + $otherCharges;
            $isAddressRequired = true;
            if ($info['is_prescription_required'] == '1') {
              $prescription_required = true;
            }
          }
        }
      }
      if($productTotal != 0){
        $pharmacy = Pharmacy::where('id',$firstPharmacyId)->first();
        if($productTotal < $pharmacy['delivery_charges_if_less']){
          $otherCharges += $pharmacy['delivery_charges'];
        }
      }

      $responseArray['isPackageAdded'] = $isPackageAdded;
      $responseArray['total'] = $total + $otherCharges;
      $responseArray['discount'] = $discount;
      $responseArray['cartItem'] = $cartItem;
      $responseArray['otherCharges'] = $otherCharges;
      $responseArray['prescription_required'] = $prescription_required;
      $responseArray['isAddressRequired'] = $isAddressRequired;
      return successResponse('Cart', $responseArray, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function buyCartInfo(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {

      $cart    = json_decode($request->cart, true);
      $cartItem = array();
      $responseArray = array();
      $productTotal = 0;
      $firstPharmacyId = 0;
      if (is_array($cart)) {
        $total = 0;
        $discount = 0;
        $otherCharges = 0;
        $itemIds = array();
        foreach ($cart as $d) {
          $item = new BuyCart;
          $item->user_id = $user->id;
          if ($d['type'] == 'product') {
            $productInfo = Product::where('id', $d['id'])->where('is_deleted', '0')->first();
            if (!empty($productInfo)) {
              $item->item_id = $d['id'];
              $item->item_type = 'product';
              $item->price = $productInfo['mrp'];
              $item->discount = $productInfo['mrp'] * ($productInfo['discount']/100);
              $item->qty = $d['qty'];

              $item->save();
              $itemIds[] = $item->id;

              $total = ($productInfo['mrp'] * $d['qty']) + $total;
              $discount = ($item->discount * $d['qty']) + $discount;

              $productTotal += (($productInfo['mrp'] * $d['qty']) - ($item->discount * $d['qty']));
              $firstPharmacyId = $productInfo['pharmacy_id'];
            }
          } else if ($d['type'] == 'treatment') {
            $treatment = Treatment::where('id', $d['id'])->where('is_deleted', '0')->first();
            if (!empty($treatment)) {
              $item->item_id = $d['id'];
              $item->item_type = 'treatment';
              $item->price = $treatment['charges_in_rs'];
              $item->discount = $treatment['discount_in_rs'];
              $item->qty = $d['qty'];

              $item->save();
              $itemIds[] = $item->id;

              $total = ($treatment['charges_in_rs']  * $d['qty']) + $total;
              $discount = ((($treatment['discount_in_rs']/100)*$item->price) * $d['qty']) + $discount;
            }
          } else if ($d['type'] == 'equp') {
            $info = DealerProduct::where('id', $d['id'])->where('is_deleted', '0')->first();
            $pArray['type'] = 'equp';
            $pArray['val'] = $info;
            $pArray['val']->qty = $d['qty'];
            $pArray['val']->req_id = $d['id'];
            $cartItem[] = $pArray;
            $total = ($info['mrp']  * $d['qty']) + $total;
            $discount = ((($info['discount']/100) * $info['mrp']) *  $d['qty']) + $discount;
            $otherCharges = ($info['delivery_charges'] * $d['qty']) + $otherCharges; 

            $itemIds[] = $d;
          }
        }
      }
      if($productTotal != 0){
        $pharmacy = Pharmacy::where('id',$firstPharmacyId)->first();
        if($productTotal < $pharmacy['delivery_charges_if_less']){
          $otherCharges += $pharmacy['delivery_charges'];
        }
      }
      $responseArray['total'] = $total + $otherCharges;
      $responseArray['discount'] = $discount;
      $responseArray['itemIds'] = $itemIds;
      return successResponse('Cart', $responseArray, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function appointmentAdd(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $doctor = Doctor::where('slug', $request->slug)->first();
      $docInfo = User::where('uid', $doctor['id'])->where('type', 'Doctor')->first();

      $appointment = new Appointment;
      $appointment->member_id    = $request->member_id;
      $appointment->type    = $request->type;
      if ($appointment->type == 'Home') {
        $appointment->address    = $request->address;
        $appointment->city    = $request->city;
        $appointment->pincode    = $request->pincode;
        $appointment->locality    = $request->locality;
      }

      $appointment->date    = $request->date;
      if ($request->time_slot != '') {
        $appointment->time_slot    = $request->time_slot;
      }
      $appointment->customer_id    = $user->uid;
      $appointment->doctor_id    = $docInfo['id'];
      $appointment->hospital_id    = $doctor['hospital_id'];
      $appointment->save();

      return successResponse('Appointment Created', $appointment, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function bookDealerProduct(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $appointment = new DealerProductPurchase;
      $appointment->user_id    = $user->uid;
      $appointment->product_id    = $request->product_id;
      $appointment->type    = $request->type;
      $appointment->qty    = $request->qty;
      $appointment->price    = $request->price;
      $appointment->address    = $request->address;
      if ($request->image != '') {
        $image = uploadBase64File($request->image, '', 'uploads');
        if ($image['status']) {
          $appointment->image = $image['file_name'];
        }
      }
      $appointment->city    = $request->city;
      $appointment->pincode    = $request->pincode;

      $appointment->save();

      return successResponse('Request Sent', $appointment, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function bookHomeCare(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $careReq = new HomeCareRequest;
      $careReq->user_id    = $user->uid;
      $careReq->care_id    = $request->care_id;
      if($request->procedure_id != ''){
        $careReq->procedure_id    = $request->procedure_id;
      }
      
      $careReq->date    = $request->date;
      $careReq->type    = $request->type;
      $careReq->qty    = $request->qty;
      $careReq->book_for    = $request->book_for;
      $careReq->price    = $request->price;
      $careReq->address    = $request->address;
      $careReq->city    = $request->city;
      $careReq->pincode    = $request->pincode;

      if ($request['id_proof'] != '') {
        $image = uploadBase64File($request['id_proof'], '', 'uploads');
        if ($image['status']) {
          $careReq->id_proof = $image['file_name'];
        }
      }

      $careReq->save();

      return successResponse('Request Sent', $careReq, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function appointmentAddLabtest(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $cart = json_decode($request->cart, true);
      $allAdded = [];
      if(count($cart) > 0){
        $appointment = new LabtestBookings;
        $appointment->user_id    = $user->id;
        $appointment->lab_id    = $request->lab_id;
        if ($request->is_home_collection != '') {
          $appointment->is_home_collection    = $request->is_home_collection;
        }
        if ($request->is_home_delivery != '') {
          $appointment->is_home_delivery    = $request->is_home_delivery;
        }
        if ($request->is_ambulance != '') {
          $appointment->is_ambulance    = $request->is_ambulance;
          if($request->is_ambulance != 'No'){
            $appointment->ambulance_price    = $request->ambulance_price;
          } 
        }
  
        $appointment->price    = $request->price;
        $appointment->h_c_price    = $request->h_c_price;
        $appointment->h_d_price    = $request->h_d_price;
        
        if ($request->address != '') {
          $appointment->address    = $request->address;
        }
         
        $appointment->save();
        foreach ($cart as $c) {
          $bInfo = new LabBookingInfoList;
          $bInfo->order_id = $appointment->id;
          $bInfo->type    = $c['type']; 
          $bInfo->test_id    = $c['id'];
          $bInfo->save();
        }  
        return successResponse('Appointment Created', $appointment, \Config::get('constants.status_code.SUCCESS'));
      }else{
        return failResponse('Invalid data request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
       
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
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
  public function addApnComment(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      if ($request->id == '') {
        $docCmt = new DoctorComment;
      } else {
        $docCmt = DoctorComment::where('id', $request->id)->first();
      }

      // $docCmt->doctor_id    = $user->uid;
      $docCmt->doctor_id    = $user->id;
      $docCmt->appointment_id    = $request->appointment_id;
      if (!empty($request->relevent_point_from_history)) {
        $docCmt->relevent_point_from_history    = $request->relevent_point_from_history;
      }
      if (!empty($request->provisional_diagnosis)) {
        $docCmt->provisional_diagnosis    = $request->provisional_diagnosis;
      }
      if (!empty($request->investigation_suggested)) {
        $docCmt->investigation_suggested    = $request->investigation_suggested;
      }
      if (!empty($request->treatment_suggested)) {
        $docCmt->treatment_suggested    = $request->treatment_suggested;
      }
      if (!empty($request->special_instruction)) {
        $docCmt->special_instruction    = $request->special_instruction;
      }
      if (!empty($request->followup_advice)) {
        $docCmt->followup_advice    = $request->followup_advice;
      }
      $docCmt->save();
      $medical_advice    = json_decode($request->medical_advice, true);

      if (!empty($medical_advice)) {
        foreach ($medical_advice as  $m) {
          $medi = new DoctorMedicineAdvice();
          $medi->doctor_id    = $user->id;
          // $medi->doctor_id    = $user->uid;
          $medi->medi_id    = $docCmt->id;
          $medi->appointment_id    = $request->appointment_id;
          $medi->formulation    = $m['formulation'];
          $medi->name    = $m['name'];
          $medi->strength    = $m['strength'];
          $medi->route_of_administration    = $m['route_of_administration'];
          $medi->frequncy    = $m['frequncy'];
          $medi->duration    = $m['duration'];
          $medi->special_instruction    = $m['special_instruction'];
          $medi->save();
        }
      }


      return successResponse('Response added', $docCmt, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function addApnCommentFileOnly(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      if ($request->id == '') {
        $docCmt = new DoctorComment;
      } else {
        $docCmt = DoctorComment::where('id', $request->id)->first();
      }
 
      $docCmt->doctor_id    = $user->id;
      $docCmt->appointment_id    = $request->appointment_id;
      if ($request->prescription_reports != '') {
        $upImg = $this->uploadBase64File($request->prescription_reports, '', 'uploads');
        if ($upImg['status']) {
          $docCmt->prescription_reports = $upImg['file_name']; 
        }
      }
      $docCmt->save(); 

      return successResponse('Response added', $docCmt, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  function uploadBase64File($fileSource, $type = '', $folder)
  {
    $image_source = explode(";base64,", $fileSource);
    if ($type == '') {
      $image_type_aux = explode("image/", $image_source[0]);
      $image_type = @$image_type_aux[1];
    } else if ($type == 'pdf') {
      $image_type = 'pdf';
    }

    $png_url = "p-" . rand(1000, 100000) . time() . "." . $image_type;
    $path = public_path() . '/' . $folder . '/' . $png_url;

    $base_decode64 = base64_decode(str_replace(' ', '+', $image_source[1]));
    if (file_put_contents($path, $base_decode64)) {
      return array('status' => true, 'file_name' => $png_url, 'type' => $image_type);
    } else {
      return array('status' => false, 'file_name' => 'Error', 'type' => '');
    }
  }
  public function getApnComment(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      if ($request->id != '') {
        $appointment = DoctorComment::where('id', $request->id)->where('appointment_id', $request->apid)->first();
      } else {
        $appointment = DoctorComment::where('appointment_id', $request->apid)->orderByDesc('id')->get();
      }

      return successResponse('Data list', $appointment, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function getApnMedi(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $appointment = DoctorMedicineAdvice::where('appointment_id', $request->apid)->where('medi_id', $request->mid)->get();

      return successResponse('Response list', $appointment, \Config::get('constants.status_code.SUCCESS'));
    } else {
      return failResponse('Login First To Proceed ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function appointmentList(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {

      $d = DB::table('appointments as a')->selectRaw('pl.*, pl.id as fm_id, a.id, a.date, a.time_slot, a.is_accepted, a.type, a.address, a.locality, a.pincode, a.city, py.status as payment_status, py.order_id, py.receipt, py.amount_paid, a.doctor_id, d.full_name as doc_name, d.email as doc_email, d.mobile as doc_mobile, d.address as doc_address, d.city as doc_city, d.pincode as doc_pincode, d.slug, d.doctor_image, "'.$user->type.'" as m_type, report.status as report_status, rv.stars, rv.comment ')->leftJoin('payments as py', 'a.payment_id', '=', 'py.id')
      ->leftJoin('patient_lists as pl', 'a.member_id', '=', 'pl.id')
      ->leftJoin("users as u",  function($q) {
        $q->on('u.id', '=', "a.doctor_id");
        $q->where('u.type', '=', 'Doctor', 'and');
      })
      ->leftJoin('doctors as d', 'u.uid', '=', 'd.id')
      ->leftJoin("chat_reports as report", "report.apn_id", "=", "a.id")
      ->leftJoin("reviews as rv",  function($q) {
        $q->on('rv.service_id', '=', 'a.id');
        $q->where('rv.type', '=', 'Appointments', 'and');
      });
      
      if($user->type == 'User'){
        $d->where('a.customer_id', @$user->uid);
      }else{
        // $d->where('u.uid', @$user->uid);
        $d->where('u.uid', @$user->uid);
      }
      if($request->apnid != '' && $request->apnid != 'undefined' && $request->apnid != '0'){
        $d->where('a.id', $request->apnid);
      }
      
      $data = $d->where('a.payment_id', '!=', '')->where('py.status', 'paid')->orderBy('a.id', 'DESC')->get();

      // $data = Appointment::select('appointments.*', 'patient_lists.name', 'patient_lists.*', 'doctors.full_name', 'doctors.email', 'doctors.mobile', 'doctors.address', 'doctors.city', 'doctors.pincode', 'doctors.slug')->join("users", "users.id", "=", "appointments.doctor_id")->join("patient_lists", "patient_lists.id", "=", "appointments.member_id")->join("doctors", "doctors.id", "=", "users.uid")->where('customer_id', @$user->uid)->get();

      return successResponse('List', $data, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function docAppointments(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if (isset($request->doc_id) && $request->doc_id != '') {
        $docId = $request->doc_id;
      } else {
        // $docId = @$user->uid;
        $docId = @$user->id;
      }
      
      $ap = DB::table('appointments as a')->selectRaw('a.id, a.date, a.time_slot, a.is_accepted, a.type, a.address, a.locality, a.pincode, a.city, py.status as payment_status, py.order_id, py.receipt, py.amount_paid, pl.name, pl.dob, pl.gender, c.mobile, c.email, rv.stars, rv.comment ')->leftJoin('payments as py', 'a.payment_id', '=', 'py.id')->leftJoin('patient_lists as pl', 'a.member_id', '=', 'pl.id')->leftJoin('customers as c', 'a.customer_id', '=', 'c.id')->where('a.doctor_id', $docId)->where('a.payment_id', '!=', '')->where('py.status', 'paid')
      ->leftJoin("reviews as rv",  function($q) {
        $q->on('rv.service_id', '=', 'a.id');
        $q->where('rv.type', '=', 'Appointments', 'and');
      });
      if ($request->type == 'Online') {
        $ap->where('a.type', 'Online');
      } else if ($request->type == 'Offline') {
        $ap->where('a.type', '!=', 'Online');
      }

      $data = $ap->orderBy('a.id', 'DESC')->get();

      return successResponse('List', $data, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function takeActionOnAppointmentsComplete(Request $request)
  { 
    $user = Auth::guard('api')->user();
    if ($user) {
      // $data = Appointment::where('id', $request->id)->where('doctor_id', @$user->uid)->first();
      $data = Appointment::where('id', $request->id)->where('doctor_id', @$user->id)->first();
      if ($data != '') {
        \DB::table('appointments')
          ->where('id', $request->id)  // find your user by their email
          ->limit(1)  // optional - to ensure only one record is updated.
          ->update(array('is_accepted' => '2'));
        return successResponse('Information Updated', $data, \Config::get('constants.status_code.SUCCESS'));
      } else {
        return failResponse('Invalid request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function takeActionOnAppointments(Request $request)
  { 
    $user = Auth::guard('api')->user();
    if ($user) {
      // $data = Appointment::where('id', $request->id)->where('doctor_id', @$user->uid)->first();
      $data = Appointment::where('id', $request->id)->where('doctor_id', @$user->id)->first();
      if ($data != '') {
        \DB::table('appointments')
          ->where('id', $request->id)  // find your user by their email
          ->limit(1)  // optional - to ensure only one record is updated.
          ->update(array('is_accepted' => '1'));
        return successResponse('Information Updated', $data, \Config::get('constants.status_code.SUCCESS'));
      } else {
        return failResponse('Invalid request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function getLatLngByPincode(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'pincode' => 'required',
    ]);

    if ($validator->fails()) {
      $messages = $validator->messages();
      foreach ($messages->all() as $message) {
        return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      $pincode = trim($request->pincode);

      $pin = PincodeMap::where('pincode', $pincode)->first();
      if (empty($pin)) {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . str_replace(' ', '%20', $pincode) . "&sensor=true&key=AIzaSyAu1H4ENLjfpmns9xAVmxXqb3awZyLpi80";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result, true);
        if (empty($data)) {
          return failResponse('Unable to find pincode please check pincode', $pincode, \Config::get('constants.status_code.SUCCESS'));
        }
        $pin = new PincodeMap;
        $pin->pincode = $pincode;
        $pin->lat = $data['results'][0]['geometry']['location']['lat'];
        $pin->lng = $data['results'][0]['geometry']['location']['lng'];
        $pin->address = $data['results'][0]['formatted_address'];
        $pin->json_info = $result;
        $pin->save();
      }

      return successResponse('Information Updated', $pin, \Config::get('constants.status_code.SUCCESS'));
    }
  }
}
