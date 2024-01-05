<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Otp;
use App\Models\User;
use App\Models\Customer;
use App\Models\Nursing;
use App\Models\Hospital;
use App\Models\Pharmacy;
use App\Models\Dealer;
use App\Models\Ambulance;
use App\Models\Laboratorist;
use App\Models\Timeslot;
use App\Models\SymptomsList;
use App\Models\TreatmentAndSurgeryList;
use App\Models\IllnessList;
use App\Models\Specialities;
use App\Models\Specialization;
use App\Models\Medical_counsiling;
use App\Models\Doctor_bank_docs;
use App\Models\Doctor_edu;
use App\Models\Bloodbank;
use App\Models\Treatment;
use App\Models\PatientList;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use Validator;
use Hash;
use DB;

class DoctorController extends Controller
{

  public function uploadTempImages(Request $request)
  {
    if ($request->hasFile('tmp_image')) {
      $image = $request->file('tmp_image');
      $name = time() . rand(100000, 999999) . '.' . $image->getClientOriginalName();
      $image->move(public_path() . '/uploads', $name);
      $response = array("uploaded" => true, "url" => asset('public/uploads/' . $name));
    } else {
      $response = array("uploaded" => false, "url" => 'Something went wrong');
    }
    return successResponse('Doctor Info', $response, \Config::get('constants.status_code.SUCCESS'));
  }

  public function docInfoForSetup(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
     

      $uid = $user->uid;
      if(isset($request->id) && $request->id != '' && $request->id != 'undefined'){
        $u = User::find($request->id);
        $uid = $u->uid;
      }

      $medical_counsiling = Medical_counsiling::all();
      $info = Doctor::where('id', $uid)->where('is_deleted', '0')->first();
      $Doctor_bank_docs = Doctor_bank_docs::where('doctor_id', $uid)->where('is_deleted', '0')->first();
      $Doctor_edu = Doctor_edu::where('doctor_id', $uid)->where('is_deleted', '0')->get();

      if ($info == '') {
        return failResponse('Invalid Request', ['uid'=> $uid], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      } else {
        if (!empty($Doctor_bank_docs)) {
          $Doctor_bank_docs->cancel_cheque = asset('doctor_image/' . $Doctor_bank_docs->cancel_cheque);
          $Doctor_bank_docs->pan_image = asset('doctor_image/' . $Doctor_bank_docs->pan_image);
        }


        $info->registration_certificate = asset('doctor_image/' . $info->registration_certificate);
        $info->doctor_image = asset('doctor_image/' . $info->doctor_image);
        $info->doctor_banner = asset('doctor_image/' . $info->doctor_banner);
        $info->degree_file = asset('doctor_image/' . $info->degree_file);
        $info->signature = asset('doctor_image/' . $info->signature);
        $info->letterhead = asset('doctor_image/' . $info->letterhead);

        return successResponse('Doctor Info', array('data' => $info, 'doctor_bank_docs' => $Doctor_bank_docs, 'medical_counsiling' => $medical_counsiling, 'Doctor_edu' => $Doctor_edu), \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function getFamilyPatients(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if (isset($request->id) && $request->id != '') {
        $info = PatientList::where('id', $request->id)->where('is_deleted', '0')->first();
      } else {
        $info = PatientList::where('user_id', $user->uid)->where('user_id', $user->uid)->where('is_deleted', '0');
        
        $info = $info->orderBy('id', 'desc')->limit(1)->get();
      }

      return successResponse('Member Info', $info, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function addFamilyPatients(Request $request)
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
        if ($data['id'] == '' || $data['id'] == 'null' || $data['id'] == 'undefined') {
          $info = new PatientList;
          $info->user_id =  $user->uid;
        } else {
          $info = PatientList::find($data['id']);
        }

        $info->name = $data['name'];
        $info->dob = $data['dob'];
        $info->gender = $data['gender'];
        if ($data['p_reports'] != '') {
          $p_reports = uploadBase64File($data['p_reports'], '', 'uploads');
          if ($p_reports['status']) {
            $info->p_reports = $p_reports['file_name'];
          }
        }
        if ($data['id_proof'] != '') {
          $id_proof = uploadBase64File($data['id_proof'], '', 'uploads');
          if ($id_proof['status']) {
            $info->id_proof = $id_proof['file_name'];
          }
        }
        if(!empty($data['is_consent'])){
          $info->is_consent = $data['is_consent'];
        }
        if(!empty($data['c_relationship'])){
          $info->c_relationship = $data['c_relationship'];
        }
        if ($data['c_relationship_proof'] != '') {
          $c_relationship_proof = uploadBase64File($data['c_relationship_proof'], '', 'uploads');
          if ($c_relationship_proof['status']) {
            $info->c_relationship_proof = $c_relationship_proof['file_name'];
          }
        }
        if ($data['consent_with_proof'] != '') {
          $consent_with_proof = uploadBase64File($data['consent_with_proof'], '', 'uploads');
          if ($consent_with_proof['status']) {
            $info->consent_with_proof = $consent_with_proof['file_name'];
          }
        }

        if(!empty($data['current_complaints_w_t_duration'])){
          $info->current_complaints_w_t_duration = $data['current_complaints_w_t_duration'];
        }
        if(!empty($data['marital_status'])){
          $info->marital_status = $data['marital_status'];
        }
        if(!empty($data['religion'])){
          $info->religion = $data['religion'];
        }
        if(!empty($data['occupation'])){
          $info->occupation = $data['occupation'];
        }
        if(!empty($data['dietary_habits'])){
          $info->dietary_habits = $data['dietary_habits'];
        }
        if(!empty($data['last_menstrual_period'])){
          $info->last_menstrual_period = $data['last_menstrual_period'];
        }
        if(!empty($data['previous_pregnancy_abortion'])){
          $info->previous_pregnancy_abortion = $data['previous_pregnancy_abortion'];
        }
        if(!empty($data['vaccination_in_children'])){
          $info->vaccination_in_children = $data['vaccination_in_children'];
        }
        if(!empty($data['residence'])){
          $info->residence = $data['residence'];
        }
        if(!empty($data['height'])){
          $info->height  = $data['height'];
        }
        if(!empty($data['weight'])){
          $info->weight  = $data['weight'];
        }
        if(!empty($data['pulse'])){
          $info->pulse  = $data['pulse'];
        }
        if(!empty($data['b_p'])){
         $info->b_p  = $data['b_p'];
        }
        if(!empty($data['temprature'])){
          $info->temprature  = $data['temprature'];
        }
        if(!empty($data['blood_suger_fasting'])){ 
          $info->blood_suger_fasting  = $data['blood_suger_fasting'];
        }
        if(!empty($data['blood_suger_random'])){ 
          $info->blood_suger_random  = $data['blood_suger_random'];
        }
        if(!empty($data['history_of_previous_diseases'])){ 
          $info->history_of_previous_diseases  = $data['history_of_previous_diseases'];
        }
        if(!empty($data['history_of_allergies'])){ 
          $info->history_of_allergies  = $data['history_of_allergies'];
        }
        if(!empty($data['history_of_previous_surgeries_or_procedures'])){ 
          $info->history_of_previous_surgeries_or_procedures  = $data['history_of_previous_surgeries_or_procedures'];
        }
        if(!empty($data['significant_family_history'])){ 
          $info->significant_family_history  = $data['significant_family_history'];
        }
        if(!empty($data['history_of_substance_abuse'])){ 
          $info->history_of_substance_abuse  = $data['history_of_substance_abuse'];
        }

        $info->save();

        return successResponse('Successfull', $info, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateDocInfoForSetup(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'full_name' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $data = $request->all();
        if ($data['doc_id'] == ''  || $data['doc_id'] == 'null') {
          $doctor = new Doctor;
          $newUser = new User;

          // $newUser->email = $doctor->email = $data['email'];
          // $newUser->mobile = $doctor->mobile = $data['mobile'];
          $newUser->type = $doctor->type = 'Doctor';
          if ($user->type == 'Hospital') {
            $doctor->hospital_id = $user->id;
            $newUser->is_verified = '1';
          }
          $doctor->slug = $this->createSlug($data['full_name'], 0, 'Doctor');
        } else {
          $doctor = Doctor::find($data['doc_id']);
          $newUser = User::where('uid',$data['doc_id'])->where('type','Doctor')->first();
          $doctor->slug = $this->createSlug($data['full_name'], $data['doc_id'], 'Doctor');
          
          $newUser->is_verified = '1';
        }
        $newUser->name = $doctor->full_name = $data['full_name'];
        if(isset($data['email']) && $data['email'] != ''){
          $newUser->email = $doctor->email = $data['email'];
        }
        if(isset($data['mobile']) && $data['mobile'] != ''){
          $newUser->mobile = $doctor->mobile = $data['mobile'];
        }
         
        $doctor->gender = $data['gender'];
        // $doctor->specialization_id = $data['specialization_id'];
        // $doctor->specialities_id = $data['specialities_id'];
        if ($data['password'] != '') {
          $newUser->password = $doctor->password = Hash::make($data['password']);
        }
        if ($data['working_days'] == '' || $data['working_days'] == '[]') {
          $data['working_days'] = '["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"]';
        }
        $doctor->working_days = $data['working_days'];

        $doctor->home_visit = $data['home_visit'];
        if ($data['consultancy_fee'] != '') {
          $doctor->consultancy_fee = $data['consultancy_fee'];
        }
        if ($data['home_consultancy_fee'] != '') {
          $doctor->home_consultancy_fee = $data['home_consultancy_fee'];
        }
        if ($data['online_consultancy_fee'] != '') {
          $doctor->online_consultancy_fee = $data['online_consultancy_fee'];
        }

        if(isset($data['is_deleted']) && $data['is_deleted'] != ''){
          $doctor->is_deleted = $data['is_deleted'];
        }
        
        $doctor->designation = $data['designation'];
        $doctor->about = $data['about'];
        $doctor->experience = $data['experience'];
        $doctor->registration_details = $data['registration_details'];
        $doctor->medical_counsiling = $data['medical_counsiling'];

        if ($data['doctor_image'] != '' && $data['doctor_image'] != 'undefined') {
          $doctor_image = uploadBase64File($data['doctor_image'], '', 'doctor_image');
          if ($doctor_image['status']) {
            $doctor->doctor_image = $doctor_image['file_name'];
          }
        }
        if ($data['doctor_banner'] != '' && $data['doctor_banner'] != 'undefined') {
          $doctor_banner = uploadBase64File($data['doctor_banner'], '', 'doctor_image');
          if ($doctor_banner['status']) {
            $doctor->doctor_banner = $doctor_banner['file_name'];
          }
        }
        if (@$data['letterhead'] != '' && @$data['letterhead'] != 'undefined') {
          $letterhead = uploadBase64File($data['letterhead'], '', 'doctor_image');
          if ($letterhead['status']) {
            $doctor->letterhead = $letterhead['file_name'];
          }
        }
        if ($data['signature'] != '' && $data['signature'] != 'undefined') {
          $signature = uploadBase64File($data['signature'], '', 'doctor_image');
          if ($signature['status']) {
            $doctor->signature = $signature['file_name'];
          }
        }
        if ($data['registration_certificate'] != '' && $data['registration_certificate'] != 'undefined') {
          $registration_certificate = uploadBase64File($data['registration_certificate'], '', 'doctor_image');
          if ($registration_certificate['status']) {
            $doctor->registration_certificate = $registration_certificate['file_name'];
          }
        }

        if ($data['degree_file'] != '' && $data['degree_file'] != 'undefined') {
          $degree_file = uploadBase64File($data['degree_file'], 'pdf', 'doctor_image');
          if ($degree_file['status']) {
            $doctor->degree_file = $degree_file['file_name'];
          }
        }

        if ($data['l_h_sign'] != '' && $data['l_h_sign'] != 'undefined') {
          $l_h_sign = uploadBase64File($data['l_h_sign'], 'pdf', 'doctor_image');
          if ($l_h_sign['status']) {
            $doctor->l_h_sign = $l_h_sign['file_name'];
          }
        }

        if ($data['l_h_image'] != '' && $data['l_h_image'] != 'undefined') {
          $l_h_image = uploadBase64File($data['l_h_image'], 'pdf', 'doctor_image');
          if ($l_h_image['status']) {
            $doctor->l_h_image = $l_h_image['file_name'];
          }
        }

        $doctor->save();

        if ($data['doc_id'] == '' || $data['doc_id'] == 'null') {
          $Doctor_bank_docs = new Doctor_bank_docs;
          $Doctor_bank_docs->doctor_id = $newUser->uid = $doctor->id;
          $Doctor_bank_docs->save();
        }
        $newUser->save();



        return successResponse('Successfull', $doctor, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  private function createNew($value, $type, $optionalId = '')
  {
    if ($type == 'deasies') {
      $data = new IllnessList;
      $data->title = $value;
    } else if ($type == 'symptom') {
      $data = new SymptomsList;
      $data->title = $value;
    } else if ($type == 'treatment') {
      $data = new TreatmentAndSurgeryList;
      $data->title = $value;
    } else if ($type == 'specialization') {
      $data = new Specialization;
      $data->degree = $value;
      $data->type = 'OTHER';
    } else if ($type == 'speciality') {
      $data = new Specialities;
      $data->speciality_name = $value;
      $data->specialization_id = $optionalId;
    }
    $data->is_approved = '0';
    $data->save();
    return $data->id;
  }
  public function updateDocInfoForSetupSS(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'specialization_id' => 'required',
        'specialities_id' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $data = $request->all();
        if ($data['doc_id'] == '') {
          $doctor = Doctor::find($user->uid);
        } else {
          $doctor = Doctor::find($data['doc_id']);
        }
        if (!empty($data['deasies_i_treat'])) {
          $dt = json_decode($data['deasies_i_treat'], true);
          for ($i = 0; $i < count($dt); $i++) {
            if (is_string($dt[$i])) {
              $dt[$i] = $this->createNew($dt[$i], 'deasies');
            }
          }
          $doctor->deasies_i_treat = json_encode($dt);
        }
        if (!empty($data['treatment_and_surgery'])) {
          $dt = json_decode($data['treatment_and_surgery'], true);
          for ($i = 0; $i < count($dt); $i++) {
            if (is_string($dt[$i])) {
              $dt[$i] = $this->createNew($dt[$i], 'treatment');
            }
          }
          $doctor->treatment_and_surgery = json_encode($dt);
        }
        if (!empty($data['symptom_i_see'])) {
          $dt = json_decode($data['symptom_i_see'], true);
          for ($i = 0; $i < count($dt); $i++) {
            if (is_string($dt[$i])) {
              $dt[$i] = $this->createNew($dt[$i], 'symptom');
            }
          }
          $doctor->symptom_i_see = json_encode($dt);
        }

        $splzList = json_decode($data['specialization_id'], true);
        for ($i = 0; $i < count($splzList); $i++) {
          if (is_string($splzList[$i])) {
            $splzList[$i] = $this->createNew($splzList[$i], 'specialization');
          }
        }
        $doctor->specialization_id = json_encode($splzList);

        $spltyList = json_decode($data['specialities_id'], true);
        for ($i = 0; $i < count($spltyList); $i++) {
          if (is_string($spltyList[$i])) {
            $spltyList[$i] = $this->createNew($spltyList[$i], 'speciality', @$splzList[0]);
          }
        }
        $doctor->specialities_id = json_encode($spltyList);

        $doctor->save();

        DB::table('doctor_edus')->where('doctor_id', $doctor->id)->whereNotIn('qualification_id', $splzList)->update(array('is_deleted' => '1'));

        return successResponse('Successfull', $doctor, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateDocInfoForSetupAward(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      
      $data = $request->all();
      if ($data['doc_id'] == '' && $user->type != 'Doctor') { 
          return failResponse('Failed : Invalid request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR')); 
      } else {

        if ($data['doc_id'] == '') {
          $doctor = Doctor::find($user->uid);
        } else {
          $doctor = Doctor::find($data['doc_id']);
        }
        if (!empty($data['award'])) {
          $doctor->award = $data['award'];
        }
        if (!empty($data['memberships_detail'])) {
          $doctor->memberships_detail = $data['memberships_detail'];
        }

        $doctor->save();

        return successResponse('Successfull', $doctor, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateDocInfoForSetupBank(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
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

        $data = $request->all();
        if ($data['doc_id'] == '') {
          $Doctor_bank_docs = Doctor_bank_docs::where('doctor_id', $user->uid)->where('is_deleted', '0')->first();
          if ($Doctor_bank_docs == null) {
            $Doctor_bank_docs = new Doctor_bank_docs;
            $Doctor_bank_docs->doctor_id = $user->uid;
          }
        } else {
          $Doctor_bank_docs = Doctor_bank_docs::where('doctor_id', $data['doc_id'])->where('is_deleted', '0')->first();
        }

        $Doctor_bank_docs->name = $data['name'];
        $Doctor_bank_docs->bank_name = $data['bank_name'];
        $Doctor_bank_docs->branch_name = $data['branch_name'];
        $Doctor_bank_docs->ifsc = $data['ifsc'];
        $Doctor_bank_docs->ac_no = $data['ac_no'];
        $Doctor_bank_docs->ac_type = $data['ac_type'];
        $Doctor_bank_docs->micr_code = $data['micr_code'];
        $Doctor_bank_docs->pan_no = $data['pan_no'];
        if ($data['cancel_cheque'] != '') {
          $cancel_cheque = uploadBase64File($data['cancel_cheque'], '', 'doctor_image');
          if ($cancel_cheque['status']) {
            $Doctor_bank_docs->cancel_cheque = $cancel_cheque['file_name'];
          }
        }
        if ($data['pan_image'] != '') {
          $pan_image = uploadBase64File($data['pan_image'], '', 'doctor_image');
          if ($pan_image['status']) {
            $Doctor_bank_docs->pan_image = $pan_image['file_name'];
          }
        }

        $Doctor_bank_docs->save();

        return successResponse('Successfull', $Doctor_bank_docs, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateHosInfoForSetupBank(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
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

        $data = $request->all(); 
        $hospitalDoc = Hospital::where('id', $user->uid)->where('is_deleted', '0')->first();
        
        $hospitalDoc->name_on_bank = $data['name'];
        $hospitalDoc->bank_name = $data['bank_name'];
        $hospitalDoc->branch_name = $data['branch_name'];
        $hospitalDoc->ifsc = $data['ifsc'];
        $hospitalDoc->ac_no = $data['ac_no'];
        $hospitalDoc->ac_type = $data['ac_type'];
        $hospitalDoc->micr_code = $data['micr_code'];
        $hospitalDoc->pan_no = $data['pan_no'];
        if ($data['cancel_cheque'] != '') {
          $cancel_cheque = uploadBase64File($data['cancel_cheque'], '', 'doctor_image');
          if ($cancel_cheque['status']) {
            $hospitalDoc->cancel_cheque = $cancel_cheque['file_name'];
          }
        }
        if ($data['pan_image'] != '') {
          $pan_image = uploadBase64File($data['pan_image'], '', 'doctor_image');
          if ($pan_image['status']) {
            $hospitalDoc->pan_image = $pan_image['file_name'];
          }
        }

        $hospitalDoc->save();

        return successResponse('Successfull', $hospitalDoc, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function updateDocInfoForSetupEdu(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'qualification_id' => 'required',
        'certificate' => 'required',
      ]);

      if ($validator->fails()) {
        $messages = $validator->messages();
        foreach ($messages->all() as $message) {
          return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      } else {

        $data = $request->all();
        if ($data['doc_id'] == '') { //WHEN DOCTOR LOGGED IN
          $Doctor_edu = Doctor_edu::where('doctor_id', $user->uid)->where('qualification_id', $data['qualification_id'])->where('is_deleted', '0')->first();
          if (empty($Doctor_edu)) {
            $Doctor_edu = new Doctor_edu;
            $Doctor_edu->doctor_id = $user->uid;
            $Doctor_edu->qualification_id = $data['qualification_id'];
          }
        } 
        else { //WHEN HOSPITAL LOGGEDIN
          $Doctor_edu = Doctor_edu::where('doctor_id', $data['doc_id'])->where('qualification_id', $data['qualification_id'])->where('is_deleted', '0')->first();
          if (empty($Doctor_edu)) {
            $Doctor_edu = new Doctor_edu;
            $Doctor_edu->doctor_id = $data['doc_id'];
            $Doctor_edu->qualification_id = $data['qualification_id'];
          }
        }

        $Doctor_edu->is_deleted = '0';
        if ($data['certificate'] != '') {
          $certificate = uploadBase64File($data['certificate'], '', 'doctor_image');
          if ($certificate['status']) {
            $Doctor_edu->certificate = $certificate['file_name'];
          }
        }

        $Doctor_edu->save();

        return successResponse('Successfull', $Doctor_edu, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }

  public function docListForHospital(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if ($request->id) {
        $doctor_list = Doctor::where('hospital_id', $user->id)->where('id', $request->id)->where('type', 'Doctor')->where('is_deleted', '0')->first();

        $Doctor_bank_docs = Doctor_bank_docs::where('doctor_id', $request->id)->where('is_deleted', '0')->first();
        $Doctor_bank_docs->cancel_cheque = asset('doctor_image/' . $Doctor_bank_docs->cancel_cheque);
        $Doctor_bank_docs->pan_image = asset('doctor_image/' . $Doctor_bank_docs->pan_image);

        $doctor_list->registration_certificate = asset('doctor_image/' . $doctor_list->registration_certificate);
        $doctor_list->doctor_image = asset('doctor_image/' . $doctor_list->doctor_image);
        $doctor_list->doctor_banner = asset('doctor_image/' . $doctor_list->doctor_banner);
        $doctor_list->degree_file = asset('doctor_image/' . $doctor_list->degree_file);
        $doctor_list->l_h_image = asset('doctor_image/' . $doctor_list->l_h_image);
        $doctor_list->l_h_sign = asset('doctor_image/' . $doctor_list->l_h_sign);

        if($doctor_list->specialities_id == ''){
          $doctor_list->specialities_id = '[]';
        }
        if($doctor_list->specialization_id == ''){
          $doctor_list->specialization_id = '[]';
        }

        $Doctor_edu = Doctor_edu::where('doctor_id', $request->id)->where('is_deleted', '0')->get();

        return successResponse('Doctor Info', array('data' => $doctor_list, 'doctor_bank_docs' => $Doctor_bank_docs, 'Doctor_edu' => $Doctor_edu), \Config::get('constants.status_code.SUCCESS'));
      } else {
        $query = Doctor::where('hospital_id', $user->id)->where('slug', '!=', '')->where('is_deleted', '0');
        $doctor_list = $query->get();
        return successResponse('Doctor List', $doctor_list, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function doctorList(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($request->id) {
      $doctor_list = Doctor::where('id', $request->id)->where('type', 'Doctor')->where('is_deleted', '0')->first();
    } else if ($request->slug && $request->slug != '') {
      $doctor_list = Doctor::where('slug', $request->slug)->where('type', 'Doctor')->where('is_deleted', '0')->first();
      if (empty($doctor_list)) {
        return successResponse('Doctors List', [], \Config::get('constants.status_code.SUCCESS'));
      }
      $jdDays = json_decode($doctor_list['working_days'], true);
      $doctor_list['days_string'] = implode(', ', $jdDays);

      $docInfo = User::where('uid', $doctor_list['id'])->where('type','Doctor')->first();
      $doctor_list['reviews'] = DB::table('reviews')
                ->select('user_id', DB::raw('COUNT(reviews.id) as total_reviews, AVG(stars) as avg_stars'))
                ->where('type', '=', 'Appointments')->where('user_id',  $docInfo['id'])
                ->groupBy('user_id')
                ->first();

      $doctor_list['Specialities'] = '';
      if ($doctor_list['specialities_id'] != '') {
        $sp = Specialities::whereIn('id', json_decode($doctor_list['specialities_id'], true))->get();
        if (count($sp) != 0) {
          $slpl = array();
          foreach ($sp  as $row) {
            $slpl[] = $row->speciality_name; 
          }
          $doctor_list['Specialities'] = implode(',',$slpl);
        }
      }
      $doctor_list['Specialization'] = '';
      if ($doctor_list['specialization_id'] != '') {
        $spl = Specialization::whereIn('id', json_decode($doctor_list['specialization_id'], true))->get();
        if (count($spl) != 0) {
          $spzl = array();
          foreach ($spl  as $row) {
            $spzl[] = $row->degree; 
          }
          $doctor_list['Specialization'] =  implode(' | ',$spzl);
        }
      }

      if ($doctor_list['medical_counsiling'] != 0) {
        $doctor_list['medical_counsiling'] = Medical_counsiling::where('id', $doctor_list['medical_counsiling'])->first();
      } else {
        $doctor_list['medical_counsiling'] = array('title' => '');
      }
      $doctor_list['Treatment'] = DB::table('treatments')
        ->select('treatments.*', 'illness_lists.title as illness_name', 'specialities.speciality_name', 'hospitals.address', 'hospitals.city', 'hospitals.pincode', 'hospitals.country')
        ->join('illness_lists', 'illness_lists.id', '=', 'treatments.illness')->join('specialities', 'specialities.id', '=', 'treatments.speciality_id')->leftJoin('hospitals', 'hospitals.id', '=', 'treatments.hospital_id')->where('doctor_id', $doctor_list['id'])->get();
      $doctor_list['SymptomsList'] = '';
      if ($doctor_list['symptom_i_see'] != '') {
        $doctor_list['SymptomsList'] = SymptomsList::whereIn('id', json_decode($doctor_list['symptom_i_see'], true))->get();
      }
      $doctor_list['IllnessList'] = '';
      if ($doctor_list['deasies_i_treat'] != '') {
        $doctor_list['IllnessList'] = IllnessList::whereIn('id', json_decode($doctor_list['deasies_i_treat'], true))->get();
      }
      $doctor_list['TreatmentAndSurgeryList'] = '';
      if ($doctor_list['treatment_and_surgery'] != '') {
        $doctor_list['TreatmentAndSurgeryList'] = TreatmentAndSurgeryList::whereIn('id', json_decode($doctor_list['treatment_and_surgery'], true))->get();
      }

      $dUser = User::where('uid', $doctor_list['id'])->where('type', 'Doctor')->where('is_deleted', '0')->first();
      $slotData['Monday'] = Timeslot::where('doctor_id', @$dUser->id)->where('is_deleted', '0')->where('day', 'Monday')->first();
      $slotData['Tuesday'] = Timeslot::where('doctor_id', @$dUser->id)->where('is_deleted', '0')->where('day', 'Tuesday')->first();
      $slotData['Wednesday'] = Timeslot::where('doctor_id', @$dUser->id)->where('is_deleted', '0')->where('day', 'Wednesday')->first();
      $slotData['Thursday'] = Timeslot::where('doctor_id', @$dUser->id)->where('is_deleted', '0')->where('day', 'Thursday')->first();
      $slotData['Friday'] = Timeslot::where('doctor_id', @$dUser->id)->where('is_deleted', '0')->where('day', 'Friday')->first();
      $slotData['Saturday'] = Timeslot::where('doctor_id', @$dUser->id)->where('is_deleted', '0')->where('day', 'Saturday')->first();
      $slotData['Sunday'] = Timeslot::where('doctor_id', @$dUser->id)->where('is_deleted', '0')->where('day', 'Sunday')->first();

      $startDate = new Carbon(date('Y-m-d'));
      $endDate = new Carbon(date('Y-m-d', strtotime("+10 days")));
      $all_dates_clinic = array();
      $all_dates_hospital = array();
      $i = 0;
      while ($startDate->lte($endDate)) {
        $all_dates_clinic[$i]['date'] = $startDate->toDateString();
        $all_dates_hospital[$i]['date'] = $startDate->toDateString();
        $timestamp = strtotime($startDate->toDateString());
        $all_dates_clinic[$i]['day'] = date('l', $timestamp);
        $all_dates_clinic[$i]['slot'] = $slotData[$all_dates_clinic[$i]['day']];
        $all_dates_hospital[$i]['day'] = date('l', $timestamp);
        $all_dates_hospital[$i]['slot'] = $slotData[$all_dates_hospital[$i]['day']];


        $startDate->addDay();
        if ($all_dates_clinic[$i]['slot'] != '') {
          $slot_interval = $all_dates_clinic[$i]['slot']['slot_interval'];
          $shift1_start_at = $all_dates_clinic[$i]['slot']['shift1_start_at'];
          $shift1_end_at = $all_dates_clinic[$i]['slot']['shift1_end_at'];
          $shift2_start_at = $all_dates_clinic[$i]['slot']['shift2_start_at'];
          $shift2_end_at = $all_dates_clinic[$i]['slot']['shift2_end_at']; 

          $time2 = strtotime($shift1_start_at);
          $time1 = strtotime($shift1_end_at);
          $minutes = ($time1 - $time2) / 60;
          $slotArray = array();
          for ($t = 0; $t < (ceil($minutes / $slot_interval)); $t++) {
            $value = date("h:i A", strtotime($shift1_start_at . " +" . ($slot_interval * ($t)) . " minutes"));
            array_push($slotArray, $value);
          }
          $all_dates_clinic[$i]['slot'] = $slotArray;

          $slotArray = array();
          $time2 = strtotime($shift2_start_at);
          $time1 = strtotime($shift2_end_at);
          $minutes = ($time1 - $time2) / 60;
          for ($t = 0; $t < (ceil($minutes / $slot_interval)); $t++) {
            $value = date("h:i A", strtotime($shift2_start_at . " +" . ($slot_interval * ($t)) . " minutes"));
            array_push($slotArray, $value);
          }
          $all_dates_hospital[$i]['slot'] = $slotArray;
          $i++;
        }
      }
      $doctor_list['slot_clinic'] =  $all_dates_clinic;
      $doctor_list['slot_hospital'] =  $all_dates_hospital;
    } else { 
      $query = Doctor::selectRaw('doctors.*, users.id as usid, users.uid, users.name, users.type, users.my_referal, users.is_verified, users.is_active')
      ->join('users', 'users.uid', '=', 'doctors.id')
      ->where('slug', '!=', '')
      ->where('doctors.is_deleted', '0')
      // ->where('users.is_active', '1')
      ->where('users.type', 'Doctor');
      if($request->search != ''){
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
      }
      if ($request->speciality_id != '') {
        $query->where('doctors.specialities_id',  'like', '%' . $request->speciality_id . '%');
      }
      if ($request->hospital_id != '') {
        $hp = User::where('uid', $request->hospital_id)->where('type','Hospital')->first();
        $query->where('doctors.hospital_id', $hp->id);
      }
      if ($request->selected_gender != '') {
        $query->where('doctors.gender', $request->selected_gender);
      }
      if ($request->price_order != '') {
        $query->orderBy('doctors.consultancy_fee', $request->price_order);
      }
      $doctor_list = $query->groupBy('doctors.id')->get();
      $sql = $query->toSql();
      if(!empty($doctor_list)){
        for($i = 0; $i < count($doctor_list); $i++){
          $docInfo = User::where('uid', $doctor_list[$i]['id'])->where('type','Doctor')->first();
          $doctor_list[$i]['reviews'] = DB::table('reviews')
                    ->select('user_id', DB::raw('COUNT(reviews.id) as total_reviews, FLOOR(AVG(stars)) as avg_stars'))
                    ->where('type', '=', 'Appointments')->where('user_id',   $docInfo['id'])
                    ->groupBy('user_id')
                    ->first();
          $doctor_list[$i]['Specialities'] = '';
          if ($doctor_list[$i]['specialities_id'] != '') {
            $sp = Specialities::whereIn('id', json_decode($doctor_list[$i]['specialities_id'], true))->get();
            if (count($sp) != 0) {
              $sA = [];
              foreach ($sp  as $row) {
                $sA[] =   $row->speciality_name ;
              }
              $doctor_list[$i]['Specialities'] = implode(', ',$sA);
            }
          }
          $doctor_list[$i]['Specialization'] = '';
          if ($doctor_list[$i]['specialization_id'] != '') {
            $spl = Specialization::whereIn('id', json_decode($doctor_list[$i]['specialization_id'], true))->get();
            if (count($spl) != 0) {
              foreach ($spl  as $row) {
                $doctor_list[$i]['Specialization'] .=   $row->type . ' - ' . $row->degree . ' | ';
              }
            }
          }
        } 
      }

    }
    return successResponse('Doctors List', $doctor_list, \Config::get('constants.status_code.SUCCESS'));
  }

  public function createSlug($title, $id = 0, $type)
  {
    $slug = Str::slug($title);
    $allSlugs = $this->getRelatedSlugs($slug, $id, $type);
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
  protected function getRelatedSlugs($slug, $id = 0, $type)
  {
    if ($type == 'Doctor') {
      return Doctor::select('slug')->where('slug', 'like', $slug . '%')
        ->where('id', '<>', $id)
        ->get();
    } else if ($type == 'Hospital') {
      return Hospital::select('slug')->where('slug', 'like', $slug . '%')
        ->where('id', '<>', $id)
        ->get();
    } else if ($type == 'Pharmacy') {
      return Pharmacy::select('slug')->where('slug', 'like', $slug . '%')
        ->where('id', '<>', $id)
        ->get();
    } else if ($type == 'Lab') {
      return Laboratorist::select('slug')->where('slug', 'like', $slug . '%')
        ->where('id', '<>', $id)
        ->get();
    } else if ($type == 'Dealer') {
      return Dealer::select('slug')->where('slug', 'like', $slug . '%')
        ->where('id', '<>', $id)
        ->get();
    } else if ($type == 'Ambulance') {
      return Ambulance::select('slug')->where('slug', 'like', $slug . '%')
        ->where('id', '<>', $id)
        ->get();
    } else if ($type == 'Bloodbank') {
      return Bloodbank::select('slug')->where('slug', 'like', $slug . '%')
        ->where('id', '<>', $id)
        ->get();
    } else if ($type == 'Nursing') {
      return Nursing::select('slug')->where('slug', 'like', $slug . '%')
        ->where('id', '<>', $id)
        ->get();
    }
  }
  function createUser($data)
  {
    $user = new User();
    $user->uid = $data['uid'];
    if($data['joined_from'] != ''){
      $user->joined_from = $data['joined_from'];
    }

    $num = sprintf("%04d", $user->uid);
    if ($data['type'] == 'Doctor') {
      $num = 'DOC'.$num;
    } else if ($data['type'] == 'Hospital') {
      $num = 'HS'.$num;
    } else if ($data['type'] == 'Pharmacy') {
      $num = 'PH'.$num;
    } else if ($data['type'] == 'Lab') {
      $num = 'LB'.$num;
    } else if ($data['type'] == 'Dealer') {
      $num = 'DEL'.$num;
    } else if ($data['type'] == 'Ambulance') {
      $num = 'AMB'.$num;
    } else if ($data['type'] == 'Bloodbank') {
      $num = 'BB'.$num;
    } else if ($data['type'] == 'Nursing') {
      $num = 'NR'.$num;
    }else{
      $num = 'REF'.$num;
    }

    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->mobile = $data['mobile'];
    $user->password = $data['password'];
    $user->type = $data['type'];
    $user->is_verified = '0';
    $user->my_referal = $num;
    $user->save();
    return $user->id;
  }
  public function verifyPassSendOtp(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'otp' => 'required',
      'password' => 'required',
      'c_password' => 'required',
      'mobile' => 'required',
      'type' => 'required'
    ]);
    if ($validator->fails()) {
      $messages = $validator->messages();
      foreach ($messages->all() as $message) {
        return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      if($request->password != $request->c_password){
        return failResponse('Confirm password mismatch', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }else{
        $user = User::where('type', $request->type)->where('mobile', $request->mobile)->first();
        if(empty($user)){
          return failResponse('No user found', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }else{
            $otp = Otp::where('uid', $user->uid)->where('type','ForgetPassword')->where('otp', $request->otp)->first();
            if(empty($otp)){
              return failResponse('Invalid OTP', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
            }else{
              $user->password =  Hash::make($request->password);
              $user->save();
              return successResponse('Password changed successfully.', [], \Config::get('constants.status_code.SUCCESS')); 
            }
        }
      }
    }
  }
  public function forgetPassSendOtp(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'mobile' => 'required',
      'type' => 'required'
    ]);

    if ($validator->fails()) {
      $messages = $validator->messages();
      foreach ($messages->all() as $message) {
        return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      $user = User::where('type', $request->type)->where('mobile', $request->mobile)->first();
      if(empty($user)){
        return failResponse('No user found', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }else{
        $otpVal = rand(100000, 999999);
        $otpVal = 123456;
        $otp = new Otp;
        $otp->type = 'ForgetPassword';
        $otp->otp = $otpVal;
        $otp->uid = $user->uid;
        $otp->save();

        return successResponse('OTP sent successfully.', [], \Config::get('constants.status_code.SUCCESS'));
      }
    }
  }
  public function signupVerifyOtp(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'id' => 'required',
      'otp' => 'required'
    ]);

    if ($validator->fails()) {
      $messages = $validator->messages();
      foreach ($messages->all() as $message) {
        return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      $otp = Otp::where('id', $request->id)->where('otp', $request->otp)->where('type', $request->type)->where('is_deleted', '0')->first();

      if ($otp == '') {
        return failResponse('Failed : Invalid OTP', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      } else {
        $user = User::find((int)$otp['uid']);

        $user->is_verified = '1';
        $user->save();

        $lUser = Auth::login($user);
        $result['token']   =  $user->createToken('login')->accessToken;
        $result['id'] =  $user->id;
        $result['user_id'] =  $user->uid;
        $result['name']    =  $user->name;
        $result['email']   =  $user->email;
        $result['mobile']   =  $user->mobile;
        $result['type']   =  $user->type;
        $result['my_referal']   =  $user->my_referal;
        $result['joined_from']   =  $user->joined_from;
        $result['htype']  = '';
        if ($user->type == 'Hospital') {
          $hospital = Hospital::find($user->uid);
          if (!empty($hospital)) {
            $result['htype']  = $hospital->type;
          }
        }
        if ($user->type == 'Doctor') {
          $doctor = Doctor::find($user->uid);
          if (!empty($doctor)) {
            $result['hospital_id']  = $doctor->hospital_id;
          }
        }
        if ($user->type == 'Ambulance') {
          $ambulance = Ambulance::find($user->uid);
          if (!empty($ambulance)) {
            $result['type_of_user']  = $ambulance->type_of_user;
          }
        }
        $result['created'] =  $user->created_at;

        return successResponse('User logged in successfully.', $result, \Config::get('constants.status_code.SUCCESS'));
      }
    }
  }

  // public function doctorSignup(Request $request)
  // {
  //   $validator = Validator::make($request->all(), [
  //     'full_name' => 'required',
  //     'email' => 'required|email|unique:doctors,email|unique:users,email',
  //     'mobile' => 'required|max:14|unique:doctors,mobile|unique:users,mobile',
  //     'password' => 'required|min:6',
  //     'doctor_image' => 'required'
  //   ]);

  //   if ($validator->fails()) {
  //     $messages = $validator->messages();
  //     foreach ($messages->all() as $message) {
  //       return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
  //     }
  //   } else {
  //     $user_info = User::where('email', $request->email)->orWhere('mobile', $request->mobile)->where('is_deleted', '0')->first();

  //     if ($user_info == '') {
  //       $doctor = new Doctor;
  //       $data = $request->all();
  //       $uData['name'] = $doctor->full_name = $data['full_name'];
  //       $uData['email'] = $doctor->email = $data['email'];
  //       $uData['mobile'] = $doctor->mobile = $data['mobile'];
  //       $uData['type'] = $doctor->type = 'Doctor';
  //       $doctor->gender = $data['gender'];
  //       $doctor->about = $data['about'];
  //       $uData['password'] = $doctor->password = Hash::make($data['password']);
  //       $doctor->experience = $data['experience'];
  //       $doctor->working_days = $data['working_days'];
  //       $doctor->doctor_banner = 'dr-list-banner.jpg';
  //       $doctor_image = uploadBase64File($data['doctor_image'], '', 'doctor_image');
  //       if ($doctor_image['status']) {
  //         $doctor->doctor_image = $doctor_image['file_name'];
  //       }

  //       $degree_file = uploadBase64File($data['degree_file'], 'pdf', 'doctor_image');
  //       if ($degree_file['status']) {
  //         $doctor->degree_file = $degree_file['file_name'];
  //       }

  //       $doctor->slug = $this->createSlug($data['full_name'], 0, 'Doctor');
  //       $doctor->save();


  //       $Doctor_bank_docs = new Doctor_bank_docs;
  //       $Doctor_bank_docs->doctor_id = $doctor->id;
  //       $Doctor_bank_docs->save();

  //       $uData['uid'] = $doctor->id;
  //       //CREATE DATA IN USER TABLE
  //       $lastInserted = $this->createUser($uData);

  //       //SEND OTP

  //       $ret['req_id'] = sendOtp($lastInserted, 'Doctor');
  //       $ret['type'] = 'Doctor';


  //       return successResponse('Successfull', $ret, \Config::get('constants.status_code.SUCCESS'));
  //     } else {
  //       if ($user_info['is_verified'] == '0') {
  //         $ret['req_id'] = sendOtp($user_info['id'], 'Doctor');
  //         $ret['type'] = 'Doctor';
  //         return successResponse('OTP Sent again', $ret, \Config::get('constants.status_code.SUCCESS'));
  //       } else {
  //         return failResponse('Failed : User already exist ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
  //       }
  //     }
  //   }
  // }

  public function customerSignup(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email|unique:customers,email|unique:users,email',
      'mobile' => 'required|max:14|unique:customers,mobile|unique:users,mobile',
      'password' => 'required|min:6'
    ]);

    if ($validator->fails()) {
      $messages = $validator->messages();
      foreach ($messages->all() as $message) {
        return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      $user_info = User::where('email', $request->email)->orWhere('mobile', $request->mobile)->where('is_deleted', '0')->first();

      $data = $request->all();
      $type = $data['signupType'];
      if ($user_info == '') {
        $uData['name'] = $data['name'];
        $uData['joined_from'] = $data['joined_from'];
        $uData['email'] = strtolower($data['email']);
        $uData['mobile'] = $data['mobile'];
        $uData['password'] =  Hash::make($data['password']);
        if ($type == 'User') {
          $userInfo = new Customer;
          $userInfo->name = $uData['name'];
          $userInfo->email = $uData['email'];
          $userInfo->mobile = $uData['mobile'];
          $userInfo->password = $uData['password'];
        } else if ($type == 'Doctor') {
          $userInfo = new Doctor;
          $userInfo->full_name = $uData['name'];
          $userInfo->email = $uData['email'];
          $userInfo->mobile = $uData['mobile'];
          $userInfo->password = $uData['password'];
          $userInfo->working_days = '["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"]';
          $userInfo->slug = $this->createSlug($uData['name'], 0, 'Doctor');
        } else if ($type == 'Hospital') {
          $userInfo = new Hospital;
          $userInfo->name = $uData['name'];
          $userInfo->phone_no = $uData['mobile'];
          $userInfo->slug = $this->createSlug($uData['name'], 0, 'Hospital');
        } else if ($type == 'Bloodbank') {
          $userInfo = new Bloodbank;
          $userInfo->name = $uData['name'];
          $userInfo->email = $uData['email'];
          $userInfo->mobile = $uData['mobile'];
          $userInfo->password = $uData['password'];
          $userInfo->slug = $this->createSlug($uData['name'], 0, 'Bloodbank');
        } else if ($type == 'Lab') {
          $userInfo = new Laboratorist;
          $userInfo->name = $uData['name'];
          $userInfo->email = $uData['email'];
          $userInfo->mobile = $uData['mobile'];
          $userInfo->password = $uData['password'];
          $userInfo->days = '["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"]';
          $userInfo->slug = $this->createSlug($uData['name'], 0, 'Lab');
        } else if ($type == 'Pharmacy') {
          $userInfo = new Pharmacy;
          $userInfo->name = $uData['name'];
          $userInfo->email = $uData['email'];
          $userInfo->mobile = $uData['mobile'];
          $userInfo->password = $uData['password'];
          $userInfo->slug = $this->createSlug($uData['name'], 0, 'Pharmacy');
        } else if ($type == 'Nursing') {
          $userInfo = new Nursing;
          $userInfo->name = $uData['name'];
          $userInfo->slug = $this->createSlug($uData['name'], 0, 'Nursing');
        } else if ($type == 'Dealer') {
          $userInfo = new Dealer;
          $userInfo->name = $uData['name'];
          $userInfo->slug = $this->createSlug($uData['name'], 0, 'Dealer');
        } else if ($type == 'Ambulance') {
          $userInfo = new Ambulance;
          $userInfo->name = $uData['name'];
          $userInfo->type_of_user = 'Firm';
          $userInfo->slug = $this->createSlug($uData['name'], 0, 'Ambulance');
        }



        $userInfo->save();
        $uData['uid'] = $userInfo->id;
        $ret['type'] = $uData['type'] = $type;
        //CREATE DATA IN USER TABLE
        $lastInserted = $this->createUser($uData);
        if ($type == 'Nursing') {
          $n = Nursing::find($userInfo->id);
          $n->buero_id = $lastInserted;
          $n->save();
        }

        //SEND OTP 
        $ret['req_id'] = sendOtp($lastInserted, $type);

        return successResponse('Successfull', $ret, \Config::get('constants.status_code.SUCCESS'));
      } else {
        if ($user_info['is_verified'] == '0' && $user_info['type'] == $type) {
          $ret['req_id'] = sendOtp($user_info['id'], $type);
          $ret['type'] = $type;
          return successResponse('OTP Sent again', $ret, \Config::get('constants.status_code.SUCCESS'));
        } else {
          return failResponse('Failed : User already exist ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      }
    }
  }
  /*public function hospitalSignup(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'address' => 'required',
      'city' => 'required',
      'pincode' => 'required',
      'contact_person' => 'required',
      'email' => 'required|email|unique:hospital__staff,email|unique:users,email',
      'mobile' => 'required|max:14|unique:hospital__staff,mobile|unique:users,mobile',
      'password' => 'required|min:6'
    ]);

    if ($validator->fails()) {
      $messages = $validator->messages();
      foreach ($messages->all() as $message) {
        return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      $user_info = User::where('email', $request->email)->orWhere('mobile', $request->mobile)->where('is_deleted', '0')->first();

      if ($user_info == '') {
        $hospital = new Hospital;
        $staff = new Hospital_Staff;
        $data = $request->all();
        $uData['name'] = $hospital->name = $data['name'];
        $staff->name = $data['contact_person'];
        $uData['email'] = $staff->email = $data['email'];
        $uData['mobile'] = $staff->mobile = $data['mobile'];
        $uData['password'] = $staff->password = Hash::make($data['password']);
        $staff->is_super = '1';

        $hospital->address = $staff->address = $data['address'];
        $hospital->city = $staff->city = $data['city'];
        $hospital->pincode = $staff->pincode = $data['pincode'];
        $hospital->country = $staff->country = $data['country'];

        $hospital->type = $data['type'];
        $hospital->beds_quantity = $data['beds_quantity'];
        $hospital->specialities_id = $data['specialities_id'];
        $hospital->procedures_id = $data['procedures_id'];
        $hospital->facilities_avialable = $data['facilities_avialable'];

        $staff->image = $hospital->image = 'dummy.png';
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'hospital_image');
          if ($image['status']) {
            $staff->image = $hospital->image = $image['file_name'];
          }
        }

        $hospital->slug = $this->createSlug($data['name'], 0, 'Hospital');

        $hospital->save();
        $staff->hospital_id = $uData['uid'] = $hospital->id;
        $staff->save();

        $ret['type'] = $uData['type'] = 'Hospital';
        //CREATE DATA IN USER TABLE
        $lastInserted = $this->createUser($uData);

        //SEND OTP 
        $ret['req_id'] = sendOtp($lastInserted, 'Hospital');


        return successResponse('Successfull', $ret, \Config::get('constants.status_code.SUCCESS'));
      } else {
        if ($user_info['is_verified'] == '0' && $user_info['type'] == 'Hospital') {
          $ret['req_id'] = sendOtp($user_info['id'], 'Hospital');
          $ret['type'] = 'Hospital';
          return successResponse('OTP Sent again', $ret, \Config::get('constants.status_code.SUCCESS'));
        } else {
          return failResponse('Failed : User already exist ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      }
    }
  } */
  /*public function bloodbankSignup(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'address' => 'required',
      'city' => 'required',
      'pincode' => 'required',
      'email' => 'required|email|unique:pharmacies,email|unique:users,email',
      'mobile' => 'required|max:14|unique:pharmacies,mobile|unique:users,mobile',
      'password' => 'required|min:6'
    ]);

    if ($validator->fails()) {
      $messages = $validator->messages();
      foreach ($messages->all() as $message) {
        return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      $user_info = User::where('email', $request->email)->orWhere('mobile', $request->mobile)->where('is_deleted', '0')->first();

      if ($user_info == '') {
        $bloodbank = new Bloodbank;
        $data = $request->all();
        $uData['email'] = $bloodbank->email = $data['email'];
        $uData['mobile'] = $bloodbank->mobile = $data['mobile'];
        $uData['password'] = $bloodbank->password = Hash::make($data['password']);


        $bloodbank->name = $data['name'];
        $uData['name'] = $bloodbank->cp_name = $data['cp_name'];
        $bloodbank->address = $data['address'];
        $bloodbank->city = $data['city'];
        $bloodbank->pincode = $data['pincode'];
        $bloodbank->country = $data['country'];
        $bloodbank->liscence_no = $data['liscence_no'];
        if ($data['liscence_file'] != '') {
          $liscence_file = uploadBase64File($data['liscence_file'], '', 'hospital_image');
          if ($liscence_file['status']) {
            $bloodbank->liscence_file = $liscence_file['file_name'];
          }
        }

        $bloodbank->image = 'dummy.png';
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'hospital_image');
          if ($image['status']) {
            $bloodbank->image = $image['file_name'];
          }
        }

        $bloodbank->slug = $this->createSlug($data['name'], 0, 'Lab');

        $bloodbank->save();
        $uData['uid'] = $bloodbank->id;

        $ret['type'] = $uData['type'] = 'Bloodbank';
        //CREATE DATA IN USER TABLE
        $lastInserted = $this->createUser($uData);

        //SEND OTP 
        $ret['req_id'] = sendOtp($lastInserted, 'Bloodbank');

        return successResponse('Successfull', $ret, \Config::get('constants.status_code.SUCCESS'));
      } else {
        if ($user_info['is_verified'] == '0' && $user_info['type'] == 'Bloodbank') {
          $ret['req_id'] = sendOtp($user_info['id'], 'Bloodbank');
          $ret['type'] = 'Bloodbank';
          return successResponse('OTP Sent again', $ret, \Config::get('constants.status_code.SUCCESS'));
        } else {
          return failResponse('Failed : User already exist ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      }
    }
  }*/
  /*public function labSignup(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'address' => 'required',
      'city' => 'required',
      'pincode' => 'required',
      'email' => 'required|email|unique:pharmacies,email|unique:users,email',
      'mobile' => 'required|max:14|unique:pharmacies,mobile|unique:users,mobile',
      'password' => 'required|min:6'
    ]);

    if ($validator->fails()) {
      $messages = $validator->messages();
      foreach ($messages->all() as $message) {
        return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      $user_info = User::where('email', $request->email)->orWhere('mobile', $request->mobile)->where('is_deleted', '0')->first();

      if ($user_info == '') {
        $lab = new Laboratorist;
        $data = $request->all();
        $uData['email'] = $lab->email = $data['email'];
        $uData['mobile'] = $lab->mobile = $data['mobile'];
        $uData['password'] = $lab->password = Hash::make($data['password']);


        $lab->name = $data['name'];
        $uData['name'] = $lab->cp_name = $data['cp_name'];
        $lab->address = $data['address'];
        $lab->city = $data['city'];
        $lab->pincode = $data['pincode'];
        $lab->country = $data['country'];
        $lab->registration_detail = $data['registration_detail'];
        if ($data['registration_file'] != '') {
          $registration_file = uploadBase64File($data['registration_file'], '', 'laboratorist_image');
          if ($registration_file['status']) {
            $lab->registration_file = $registration_file['file_name'];
          }
        }

        $lab->image = 'dummy.png';
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'laboratorist_image');
          if ($image['status']) {
            $lab->image = $image['file_name'];
          }
        }

        $lab->slug = $this->createSlug($data['name'], 0, 'Lab');

        $lab->save();
        $uData['uid'] = $lab->id;


        $ret['type'] = $uData['type'] = 'Lab';
        //CREATE DATA IN USER TABLE
        $lastInserted = $this->createUser($uData);

        //SEND OTP 
        $ret['req_id'] = sendOtp($lastInserted, 'Lab');

        return successResponse('Successfull', $ret, \Config::get('constants.status_code.SUCCESS'));
      } else {
        if ($user_info['is_verified'] == '0' && $user_info['type'] == 'Lab') {
          $ret['req_id'] = sendOtp($user_info['id'], 'Lab');
          $ret['type'] = 'Lab';
          return successResponse('OTP Sent again', $ret, \Config::get('constants.status_code.SUCCESS'));
        } else {
          return failResponse('Failed : User already exist ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      }
    }
  }*/
  /*public function pharmacySignup(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'address' => 'required',
      'city' => 'required',
      'pincode' => 'required',
      'email' => 'required|email|unique:pharmacies,email|unique:users,email',
      'mobile' => 'required|max:14|unique:pharmacies,mobile|unique:users,mobile',
      'password' => 'required|min:6'
    ]);

    if ($validator->fails()) {
      $messages = $validator->messages();
      foreach ($messages->all() as $message) {
        return failResponse('Failed : ' . $message, [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      $user_info = User::where('email', $request->email)->orWhere('mobile', $request->mobile)->where('is_deleted', '0')->first();

      if ($user_info == '') {
        $pharmacy = new Pharmacy;
        $data = $request->all();
        $uData['email'] = $pharmacy->email = $data['email'];
        $uData['mobile'] = $pharmacy->mobile = $data['mobile'];
        $uData['password'] = $pharmacy->password = Hash::make($data['password']);


        $pharmacy->name = $data['name'];
        $pharmacy->cp_first_name = $data['cp_first_name'];
        $pharmacy->cp_last_name = $data['cp_last_name'];
        $pharmacy->cp_middle_name = $data['cp_middle_name'];
        $pharmacy->address = $data['address'];
        $pharmacy->city = $data['city'];
        $pharmacy->pincode = $data['pincode'];
        $pharmacy->country = $data['country'];
        $pharmacy->drug_liscence_number = $data['drug_liscence_number'];
        $pharmacy->drug_liscence_valid_upto = $data['drug_liscence_valid_upto'];


        $uData['name'] = $pharmacy->cp_first_name . ' ' . $pharmacy->cp_middle_name . ' ' . $pharmacy->cp_last_name;

        $pharmacy->image = 'dummy.png';
        if ($data['image'] != '') {
          $image = uploadBase64File($data['image'], '', 'pharmacy_image');
          if ($image['status']) {
            $pharmacy->image = $image['file_name'];
          }
        }
        if ($data['drug_liscence_file'] != '') {
          $drug_liscence_file = uploadBase64File($data['drug_liscence_file'], '', 'pharmacy_image');
          if ($drug_liscence_file['status']) {
            $pharmacy->drug_liscence_file = $drug_liscence_file['file_name'];
          }
        }

        $pharmacy->slug = $this->createSlug($data['name'], 0, 'Pharmacy');

        $pharmacy->save();
        $uData['uid'] = $pharmacy->id;


        $ret['type'] = $uData['type'] = 'Pharmacy';
        //CREATE DATA IN USER TABLE
        $lastInserted = $this->createUser($uData);

        //SEND OTP 
        $ret['req_id'] = sendOtp($lastInserted, 'Pharmacy');


        return successResponse('Successfull', $ret, \Config::get('constants.status_code.SUCCESS'));
      } else {
        if ($user_info['is_verified'] == '0' && $user_info['type'] == 'Pharmacy') {
          $ret['req_id'] = sendOtp($user_info['id'], 'Pharmacy');
          $ret['type'] = 'Pharmacy';
          return successResponse('OTP Sent again', $ret, \Config::get('constants.status_code.SUCCESS'));
        } else {
          return failResponse('Failed : User already exist ', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
        }
      }
    }
  }*/

  public function getDocWFieldList(Request $request)
  {
    $deasiesList = IllnessList::all();
    $symptomList = SymptomsList::all();
    $treatmentList = TreatmentAndSurgeryList::all();

    return successResponse('Illness List', array('symptomList' => $symptomList, 'deasiesList' => $deasiesList, 'treatmentList' => $treatmentList), \Config::get('constants.status_code.SUCCESS'));
  }
  public function getIllnessList(Request $request)
  {
    $tList = IllnessList::all();

    return successResponse('Illness List',  $tList, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getTreatmentList(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if (isset($request->doctor_id) && $request->doctor_id != '') {
        $doctorId = $request->doctor_id;
      } else {
        $doctorId = $user->uid;
      }
      if ($request->id) {
        $tList = Treatment::where('id', $request->id)->where('is_deleted', '0')->first();
      } else {
        if ($user->type == 'Doctor') {
          $tList = Treatment::where('doctor_id', $doctorId)->get();
        } else {
          $tList = Treatment::where('hospital_id', $user->uid)->get();
        }
      }
      return successResponse('Treatment List',  $tList, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function getTreatmentListByHospital(Request $request)
  {
      $tList = Treatment::where('hospital_id', $request->hospital_id)->get();
      return successResponse('Treatment List',  $tList, \Config::get('constants.status_code.SUCCESS'));
  
  }
  public function updateTreatments(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $validator = Validator::make($request->all(), [
        'doctor_id' => 'required',
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
          $treatment = Treatment::where('id', $data['id'])->first();
        } else {
          $treatment = new Treatment;
          $treatment->uid = $user->id;
          $treatment->is_active = '0';
        }


        $treatment->doctor_id = $data['doctor_id'];
        if($data['hospital_id'] != ''){
          $treatment->hospital_id = $data['hospital_id'];
        }
        $treatment->package_name = $data['package_name'];
        $treatment->package_location = $data['package_location'];
        if ($treatment->package_location == 'Hospital') {
          $treatment->hospital_name = $data['hospital_name'];
          $treatment->hospital_address = $data['hospital_address'];
        }
        $treatment->speciality_id = $data['speciality_id'];
        $treatment->illness = $data['illness'];
        $treatment->stay_type = $data['stay_type'];
        $treatment->charges_in_rs = $data['charges_in_rs'];
        $treatment->discount_in_rs = $data['discount_in_rs'];
        // $treatment->charges_in_doller = $data['charges_in_doller'];
        // $treatment->discount_in_doller = $data['discount_in_doller'];
        $treatment->details = $data['details'];

        $treatment->save();

        return successResponse('Successfull', $treatment, \Config::get('constants.status_code.SUCCESS'));
      }
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
}
