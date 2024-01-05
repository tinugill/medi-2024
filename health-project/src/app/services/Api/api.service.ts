import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
const BASE_API_URL = environment.base_url;

let httpOptions = {
  headers: new HttpHeaders({
    'Content-Type': 'application/x-www-form-urlencoded',
  }),
};

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  constructor(private http: HttpClient) {}
  //VERIFICATION AFTER SIGNUP
  verifyUsingEmail(data: any = []): Observable<any> {
    const body = new HttpParams()
      .set('token', data.token)
      .set('i', data.i)
      .set('email', data.email);
    return this.http.post(
      BASE_API_URL + 'i-f-verify-account-using-email',
      body,
      httpOptions
    );
  }
  bookHomeCare(form: any): Observable<any> {
    const body = new HttpParams()
      .set('care_id', form.care_id || '')
      .set('type', form.type)
      .set('date', form.date)
      .set('price', form.price)
      .set('qty', form.qty)
      .set('procedure_id', form.procedure_id || '')
      .set('book_for', form.book_for)
      .set('id_proof', form.id_proof || '')
      .set('address', form.address)
      .set('city', form.city)
      .set('pincode', form.pincode);
    return this.http.post(BASE_API_URL + 'book-home-care', body, httpOptions);
  }
  bookDealerProduct(form: any): Observable<any> {
    const body = new HttpParams()
      .set('product_id', form.product_id)
      .set('type', form.type)
      .set('price', form.price)
      .set('qty', form.qty)
      .set('address', form.address)
      .set('image', form.image || '')
      .set('city', form.city)
      .set('pincode', form.pincode);
    return this.http.post(BASE_API_URL + 'book-dealer-product', body, httpOptions);
  }
  bookAppointmentLabtest(form: any): Observable<any> {
    const body = new HttpParams()
      .set('cart', JSON.stringify(form.cart))
      .set('lab_id', form.lab_id)
      .set('is_home_collection', form.is_home_collection)
      .set('is_home_delivery', form.is_home_delivery)
      .set('is_ambulance', form.is_ambulance)
      .set('price', form.price)
      .set('h_c_price', form.h_c_price)
      .set('h_d_price', form.h_d_price)
      .set('ambulance_price', form.ambulance_price)
      .set('address', form.address);
    return this.http.post(BASE_API_URL + 'appointment-labtest', body, httpOptions);
  }
  bookAppointment(form: any): Observable<any> {
    const body = new HttpParams()
      .set('member_id', form.member_id)
      .set('type', form.type)
      .set('date', form.date)
      .set('slug', form.slug)
      .set('address', form.address)
      .set('city', form.city)
      .set('pincode', form.pincode)
      .set('locality', form.locality)
      .set('time_slot', form.time_slot);
    return this.http.post(BASE_API_URL + 'appointment', body, httpOptions);
  }
  addFamilyMember(form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '')
      .set('name', form.name)
      .set('dob', form.dob)
      .set('gender', form.gender)
      .set('p_reports', form.p_reports)
      .set('id_proof', form.id_proof || '')
      .set('is_consent', form.is_consent)
      .set('c_relationship', form.c_relationship)
      .set('c_relationship_proof', form.c_relationship_proof || '')
      .set('consent_with_proof', form.consent_with_proof || '')
      .set('current_complaints_w_t_duration', form.current_complaints_w_t_duration)
      .set('marital_status', form.marital_status)
      .set('religion', form.religion)
      .set('occupation', form.occupation)
      .set('dietary_habits', form.dietary_habits)
      .set('last_menstrual_period', form.last_menstrual_period)
      .set('previous_pregnancy_abortion', form.previous_pregnancy_abortion)
      .set('vaccination_in_children', form.vaccination_in_children)
      .set('residence', form.residence)
      .set('height', form.height)
      .set('weight', form.weight)
      .set('pulse', form.pulse)
      .set('b_p', form.b_p)
      .set('temprature', form.temprature)
      .set('blood_suger_fasting', form.blood_suger_fasting)
      .set('blood_suger_random', form.blood_suger_random)
      .set('history_of_previous_diseases', form.history_of_previous_diseases)
      .set('history_of_allergies', form.history_of_allergies)
      .set('history_of_previous_surgeries_or_procedures', form.history_of_previous_surgeries_or_procedures)
      .set('significant_family_history', form.significant_family_history)
      .set('history_of_substance_abuse', form.history_of_substance_abuse);
    return this.http.post(
      BASE_API_URL + 'add-family-member',
      body,
      httpOptions
    );
  }
  getDealerEqpCategory(id: any = '', slug : any = ''): Observable<any> {
    const body = new HttpParams()
    .set('id', id).set('slug', slug);
    return this.http.post(
      BASE_API_URL + 'get-dealer-eqp-category',
      body,
      httpOptions
    );
  } 
  getDealerProductList(id: any = '', search : any = ''): Observable<any> {
    const body = new HttpParams()
    .set('id', id).set('q', search);
    return this.http.post(
      BASE_API_URL + 'get-dealer-product-list',
      body,
      httpOptions
    );
  } 
  updateDealerProductInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '')
      .set('item_name', form.item_name)
      .set('company', form.company)
      .set('image', form.image || '')
      .set('image_2', form.image_2 || '')
      .set('image_3', form.image_3 || '')
      .set('image_4', form.image_4 || '')
      .set('description', form.description)
      .set('mrp', form.mrp)
      .set('discount', form.discount)
      .set('delivery_charges', form.delivery_charges)
      .set('is_rent', form.is_rent)
      .set('pack_size', form.pack_size)
      .set('rent_per_day', form.rent_per_day)
      .set('security_for_rent', form.security_for_rent)
      .set('delivery_charges_for_rent', form.delivery_charges_for_rent)
      .set('manufacturer_address', form.manufacturer_address)
      .set('category_id', form.category_id)
      .set('is_prescription_required', form.is_prescription_required)
      .set('status', form.status);
    return this.http.post(
      BASE_API_URL + 'update-dealer-product-info',
      body,
      httpOptions
    );
  }

  getAppointment(apnid:any = ''): Observable<any> {
    return this.http.get(BASE_API_URL + 'get-appointment?apnid='+apnid, httpOptions);
  }
 
  getIllnessList(): Observable<any> {
    return this.http.get(BASE_API_URL + 'get-illness-list', httpOptions);
  }
 
  getDocInfo(id:any = ''): Observable<any> {
    return this.http.get(BASE_API_URL + 'get-doc-info?id='+id, httpOptions);
  }
  getHospInfo(): Observable<any> {
    return this.http.get(BASE_API_URL + 'get-hosp-info', httpOptions);
  }
  getMyLabInfo(): Observable<any> {
    return this.http.get(BASE_API_URL + 'get-lab-info', httpOptions);
  }
  getMyPharmasyInfo(): Observable<any> {
    return this.http.get(BASE_API_URL + 'get-pharmacy-info', httpOptions);
  }
  getMyNursingInfo(editId:any=''): Observable<any> {
    return this.http.get(BASE_API_URL + 'get-nursing-info?id='+editId, httpOptions);
  }
  getMyDealerInfo(): Observable<any> {
    return this.http.get(BASE_API_URL + 'get-dealer-info', httpOptions);
  }
  getMyAmbInfo(): Observable<any> {
    return this.http.get(BASE_API_URL + 'get-amb-info', httpOptions);
  }
  getMyBloodbankInfo(): Observable<any> {
    return this.http.get(BASE_API_URL + 'get-bloodbank-info', httpOptions);
  }
  getMyBBDonation(): Observable<any> {
    return this.http.get(
      BASE_API_URL + 'get-bloodbank-donation-req',
      httpOptions
    );
  }
  donationComplete(id: any): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'bloodbank-donation-complete',
      body,
      httpOptions
    );
  }
  reportApn(apnid: any, message:any): Observable<any> {
    const body = new HttpParams().set('apnid', apnid).set('message', message);
    return this.http.post(
      BASE_API_URL + 'report-chat',
      body,
      httpOptions
    );
  }
  getExecutive(id: any): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-executive',
      body,
      httpOptions
    );
  }
  getAmbulanceList(id: any): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-my-ambulance-list',
      body,
      httpOptions
    );
  }
  getAmbTypeList(): Observable<any> { 
    return this.http.get(
      BASE_API_URL + 'get-ambulance-type-list', 
      httpOptions
    );
  }
  getAmbulanceDriverList(id: any): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-my-ambulance-driver-list',
      body,
      httpOptions
    );
  }
  updateAmbDriverListInfo(form: any): Observable<any> {
    const body = new HttpParams()
    .set('id', form.id || '')
    .set('driver_name', form.driver_name)
    .set('image', form.image || '')
    .set('liscence_no', form.liscence_no)
    .set('liscence_photo', form.liscence_photo)
    .set('is_deleted', form.is_deleted)
    .set('mobile', form.mobile);
    return this.http.post(
      BASE_API_URL + 'update-ambulance-deiver-list',
      body,
      httpOptions
    );
  }
  updateAmbListInfo(form: any): Observable<any> {
    const body = new HttpParams()
    .set('id', form.id || '')
    .set('regis_no', form.regis_no || '')
    .set('regis_proof', form.regis_proof)
    .set('ambulance_type', form.ambulance_type)
    .set('charges_per_day', form.charges_per_day)
    .set('discount_per_day', form.discount_per_day)
    .set('charges_per_km', form.charges_per_km)
    .set('discount_per_km', form.discount_per_km)
    .set('img_1', form.img_1 || '')
    .set('img_2', form.img_2 || '')
    .set('img_3', form.img_3 || '')
    .set('img_4', form.img_4 || '')
    .set('img_5', form.img_5 || '')
    .set('img_6', form.img_6 || '')
    .set('is_deleted', form.is_deleted || '');
    return this.http.post(
      BASE_API_URL + 'update-ambulance-list',
      body,
      httpOptions
    );
  }
  updateExecutive(form: any): Observable<any> {
    const body = new HttpParams()
    .set('id', form.id || '')
    .set('name', form.name)
    .set('mobile', form.mobile || '')
    .set('is_deleted', form.is_deleted || '')
    .set('type', form.type);
    return this.http.post(
      BASE_API_URL + 'update-executive',
      body,
      httpOptions
    );
  }
  sendMessage(id: any, msg:any, type:any): Observable<any> {
    const body = new HttpParams().set('id', id).set('msg', msg).set('type', type);
    return this.http.post(
      BASE_API_URL + 'send-message-apn',
      body,
      httpOptions
    );
  }
  updateMeetingSecret(id: any, token:any): Observable<any> {
    const body = new HttpParams().set('id', id).set('token', token);
    return this.http.post(
      BASE_API_URL + 'update-zoom-details',
      body,
      httpOptions
    );
  }
  getZoomDetails(appointment_id: any, msgId:any, msg:any): Observable<any> {
    const body = new HttpParams().set('appointment_id', appointment_id).set('msgId', msgId).set('msg', msg);
    return this.http.post(
      BASE_API_URL + 'get-zoom-details',
      body,
      httpOptions
    );
  }
  createVideoLink(id: any): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'create-video-link',
      body,
      httpOptions
    );
  }
  getApnComment(apid:any, id: any = ''): Observable<any> {
    const body = new HttpParams().set('apid', apid).set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-apn-comment',
      body,
      httpOptions
    );
  }
  getDiagnosisList(title: any = ''): Observable<any> {
    const body = new HttpParams().set('title', title);
    return this.http.post(
      BASE_API_URL + 'get-diagnosis-list',
      body,
      httpOptions
    );
  }
  submitApnComment(apid:any, form: any): Observable<any> {
    const body = new HttpParams()
    .set('appointment_id', apid || '')
    .set('id', form.id || '')
    .set('relevent_point_from_history', form.relevent_point_from_history)
    .set('provisional_diagnosis', form.provisional_diagnosis)
    .set('investigation_suggested', form.investigation_suggested)
    .set('treatment_suggested', form.treatment_suggested)
    .set('special_instruction', form.special_instruction)
    .set('followup_advice', form.followup_advice)
    .set('medical_advice', JSON.stringify(form.medical_advice));
    return this.http.post(
      BASE_API_URL + 'add-apn-comment',
      body,
      httpOptions
    );
  }
  submitPrsForm(apid:any, form: any): Observable<any> {
    const body = new HttpParams()
    .set('appointment_id', apid || '')
    .set('id', form.id || '')
    .set('prescription_reports', form.prescription_reports);
    return this.http.post(
      BASE_API_URL + 'add-apn-comment-file-only',
      body,
      httpOptions
    );
  }

  getReviews(type:any, id: any): Observable<any> {
    const body = new HttpParams() 
    .set('type', type)
    .set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-all-reviews',
      body,
      httpOptions
    );
  }
  getApnMedicien(apid:any, mid: any = ''): Observable<any> {
    const body = new HttpParams().set('apid', apid).set('mid', mid);
    return this.http.post(
      BASE_API_URL + 'get-apn-medicien',
      body,
      httpOptions
    );
  }
  
  getMessage(id: any): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-message-apn',
      body,
      httpOptions
    );
  }
  updateBloodbankSetupInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.name)
      .set('owner_name', form.owner_name)
      .set('public_number', form.public_number)
      .set('phone_no', form.phone_no)
      .set('about', form.about) 
      .set('image', form.image || '')
      .set('about', form.about)
      .set('liscence_no', form.liscence_no)
      .set('liscence_file', form.liscence_file)
      .set('days', JSON.stringify(form.days));
    return this.http.post(
      BASE_API_URL + 'bloodbank-update-setup-info',
      body,
      httpOptions
    );
  }
  ambulanceBookingForm(form: any, ambulance_id: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.name) 
      .set('mobile', form.mobile)
      .set('address', form.address) 
      .set('drop_address', form.drop_address) 
      .set('booking_type', form.booking_type)
      .set('booking_for', form.booking_for)
      .set('date', form.date) 
      .set('service_ambulance_id', form.service_ambulance_id) 
      .set('ambulance_id', ambulance_id);
    return this.http.post(
      BASE_API_URL + 'ambulance-booking-form',
      body,
      httpOptions
    );
  }
  bloodDonationForm(form: any, bloodbank_id: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.name)
      .set('blood_group', encodeURIComponent(form.blood_group))
      .set('mobile', form.mobile)
      .set('email', form.email)
      .set('date', form.date)
      .set('available_in_emergency', form.available_in_emergency)
      .set('bloodbank_id', bloodbank_id);
    return this.http.post(
      BASE_API_URL + 'bloodbank-donation-form',
      body,
      httpOptions
    );
  }
  updateBloodbankSetupInfoCp(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.cp_name)
      .set('email', form.email)
      .set('mobile', form.mobile)
      .set('password', form.password);
    return this.http.post(
      BASE_API_URL + 'bloodbank-update-setup-info-cp',
      body,
      httpOptions
    );
  }
  submitReview(form: any): Observable<any> {
    const body = new HttpParams()
      .set('service_id', form.service_id)
      .set('type', form.type)
      .set('user_id', form.user_id)
      .set('star', form.star)
      .set('review', form.review || '');
    return this.http.post(
      BASE_API_URL + 'review-submit-action',
      body,
      httpOptions
    );
  }
  getSingleReview(form: any): Observable<any> {
    const body = new HttpParams()
      .set('service_id', form.service_id)
      .set('type', form.type)
      .set('user_id', form.user_id);
    return this.http.post(
      BASE_API_URL + 'review-get-single-action',
      body,
      httpOptions
    );
  }
  updateHosSetupInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.name)
      .set('type', form.type)
      .set('phone_no', form.phone_no)
      .set('beds_quantity', form.beds_quantity)
      .set('image', form.image || '')
      .set('about', form.about)
      .set('registration_details', form.registration_details)
      .set('registration_file', form.registration_file)
      .set('accredition_details', form.accredition_details)
      .set('accredition_certificate', form.accredition_certificate)
      .set('facilities_avialable', JSON.stringify(form.facilities_avialable))
      .set('empanelments', JSON.stringify(form.empanelments))
      .set('specialities_id', JSON.stringify(form.specialities_id))
      .set('procedures_id', JSON.stringify(form.procedures_id));
    return this.http.post(
      BASE_API_URL + 'hosp-update-setup-info',
      body,
      httpOptions
    );
  }
  updateHosSetupInfoCp(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.contact_person_name)
      .set('email', form.email)
      .set('mobile', form.mobile)
      .set('password', form.password);
    return this.http.post(
      BASE_API_URL + 'hosp-update-setup-info-cp',
      body,
      httpOptions
    );
  }

  updateNursingSetupInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '') 
      .set('name', form.name) 
      .set('regis_type', form.regis_type) 
      .set('mobile', form.mobile) 
      .set('email', form.email) 
      .set('image', form.image || '')
      .set('about', form.about)
      .set('part_fill_time', form.part_fill_time)
      .set('work_hours', form.work_hours)
      .set('is_weekof_replacement', form.is_weekof_replacement)
      .set('custom_remarks', form.custom_remarks)
      .set('visit_charges', form.visit_charges)
      .set('per_hour_charges', form.per_hour_charges)
      .set('per_days_charges', form.per_days_charges)
      .set('per_month_charges', form.per_month_charges)
      .set('banner', form.banner)
      .set('type', form.type)
      .set('experience', form.experience)
      .set('gender', form.gender)
      .set('registration_certificate', form.registration_certificate || '')
      .set('id_proof', form.id_proof || '')
      .set('qualification', form.qualification || '')
      .set('degree', form.degree || '')
      .set('is_deleted', form.is_deleted || '')
      ;
    return this.http.post(
      BASE_API_URL + 'nursing-update-setup-info',
      body,
      httpOptions
    );
  }
  updateNursingSetupInfoCp(id:any,form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', id)
      .set('name', form.cp_name)
      .set('email', form.email)
      .set('mobile', form.mobile)
      .set('password', form.password);
    return this.http.post(
      BASE_API_URL + 'nursing-update-setup-info-cp',
      body,
      httpOptions
    );
  }
  updateNursingSetupInfoBank(id:any,form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', id)
      .set('name_on_bank', form.name)
      .set('bank_name', form.bank_name)
      .set('branch_name', form.branch_name)
      .set('ifsc', form.ifsc)
      .set('ac_no', form.ac_no)
      .set('ac_type', form.ac_type)
      .set('micr_code', form.micr_code || '')
      .set('cancel_cheque', form.cancel_cheque || '')
      .set('pan_no', form.pan_no)
      .set('pan_image', form.pan_image || '');
    return this.http.post(
      BASE_API_URL + 'nursing-update-setup-info-bank',
      body,
      httpOptions
    );
  }

  
  updateDealerSetupInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.name) 
      .set('owner_name', form.owner_name)
      .set('owner_id', form.owner_id)
      .set('partner_name', form.partner_name)
      .set('partner_id', form.partner_id)
      .set('image', form.image || '')
      .set('about', form.about) 
      .set('gstin', form.gstin)
      .set('tin', form.tin)
      .set('gstin_proof', form.gstin_proof)
      .set('tin_proof', form.tin_proof) 
      .set('banner', form.banner)  
      .set('registration_certificate', form.registration_certificate)
      ;
    return this.http.post(
      BASE_API_URL + 'dealer-update-setup-info',
      body,
      httpOptions
    );
  }
  
  updateAmbSetupInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.name) 
      .set('owner_name', form.owner_name) 
      .set('public_number', form.public_number) 
      .set('type_of_user', form.type_of_user || '')
      .set('image', form.image || '')
      .set('about', form.about) 
      .set('gstin', form.gstin)
      .set('aadhar', form.aadhar)
      .set('gstin_proof', form.gstin_proof)
      .set('aadhar_proof', form.aadhar_proof) 
      .set('banner', form.banner)  
      .set('registration_certificate', form.registration_certificate)
      ;
    return this.http.post(
      BASE_API_URL + 'amb-update-setup-info',
      body,
      httpOptions
    );
  }

  updateDealerSetupInfoCp(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.cp_name)
      .set('email', form.email)
      .set('mobile', form.mobile)
      .set('password', form.password);
    return this.http.post(
      BASE_API_URL + 'dealer-update-setup-info-cp',
      body,
      httpOptions
    );
  }
  updateAmbSetupInfoCp(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.cp_name)
      .set('email', form.email)
      .set('mobile', form.mobile)
      .set('password', form.password);
    return this.http.post(
      BASE_API_URL + 'amb-update-setup-info-cp',
      body,
      httpOptions
    );
  }
  updateDealerSetupInfoBank(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name_on_bank', form.name)
      .set('bank_name', form.bank_name)
      .set('branch_name', form.branch_name)
      .set('ifsc', form.ifsc)
      .set('ac_no', form.ac_no)
      .set('ac_type', form.ac_type)
      .set('micr_code', form.micr_code || '')
      .set('cancel_cheque', form.cancel_cheque || '')
      .set('pan_no', form.pan_no)
      .set('pan_image', form.pan_image || '');
    return this.http.post(
      BASE_API_URL + 'dealer-update-setup-info-bank',
      body,
      httpOptions
    );
  }
  updateAmbSetupInfoBank(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name_on_bank', form.name)
      .set('bank_name', form.bank_name)
      .set('branch_name', form.branch_name)
      .set('ifsc', form.ifsc)
      .set('ac_no', form.ac_no)
      .set('ac_type', form.ac_type)
      .set('micr_code', form.micr_code || '')
      .set('cancel_cheque', form.cancel_cheque || '')
      .set('pan_no', form.pan_no)
      .set('pan_image', form.pan_image || '');
    return this.http.post(
      BASE_API_URL + 'amb-update-setup-info-bank',
      body,
      httpOptions
    );
  }


  updatePharmacySetupInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.name)
      .set('owner_name', form.owner_name)
      .set('owner_id', form.owner_id)
      .set('partner_name', form.partner_name)
      .set('partner_id', form.partner_id)
      .set('pharmacist_name', form.pharmacist_name)
      .set('pharmacist_regis_no', form.pharmacist_regis_no)
      .set('pharmacist_regis_upload', form.pharmacist_regis_upload)
      .set('gstin', form.gstin)
      .set('gstin_certificate', form.gstin_certificate) 
      .set('image', form.image || '')
      .set('about', form.about) 
      .set('delivery_charges_if_less', form.delivery_charges_if_less)
      .set('delivery_charges', form.delivery_charges)
      .set('drug_liscence_valid_upto', form.drug_liscence_valid_upto)
      .set('drug_liscence_number', form.drug_liscence_number)
      .set('drug_liscence_file', form.drug_liscence_file);
    return this.http.post(
      BASE_API_URL + 'pharmacy-update-setup-info',
      body,
      httpOptions
    );
  }
  updatePharmacySetupInfoCp(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.cp_name)
      .set('email', form.email)
      .set('mobile', form.mobile)
      .set('password', form.password);
    return this.http.post(
      BASE_API_URL + 'pharmacy-update-setup-info-cp',
      body,
      httpOptions
    );
  }
  updatePharmacySetupInfoBank(form: any, doc_id: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('name_on_bank', form.name)
      .set('bank_name', form.bank_name)
      .set('branch_name', form.branch_name)
      .set('ifsc', form.ifsc)
      .set('ac_no', form.ac_no)
      .set('ac_type', form.ac_type)
      .set('micr_code', form.micr_code || '')
      .set('cancel_cheque', form.cancel_cheque || '')
      .set('pan_no', form.pan_no)
      .set('pan_image', form.pan_image || '');
    return this.http.post(
      BASE_API_URL + 'pharmacy-update-setup-info-bank',
      body,
      httpOptions
    );
  }
  updateLabSetupInfoBank(form: any, doc_id: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('name_on_bank', form.name)
      .set('bank_name', form.bank_name)
      .set('branch_name', form.branch_name)
      .set('ifsc', form.ifsc)
      .set('ac_no', form.ac_no)
      .set('ac_type', form.ac_type)
      .set('micr_code', form.micr_code || '')
      .set('cancel_cheque', form.cancel_cheque || '')
      .set('pan_no', form.pan_no)
      .set('pan_image', form.pan_image || '');
    return this.http.post(
      BASE_API_URL + 'lab-update-setup-info-bank',
      body,
      httpOptions
    );
  }
  updateLabSetupInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.name)
      .set('phone_no', form.phone_no)
      .set('owner_name', form.owner_name)
      .set('owner_id', form.owner_id)
      .set('h_c_fee', form.h_c_fee)
      .set('h_c_fee_apply_before', form.h_c_fee_apply_before)
      .set('r_d_fee', form.r_d_fee)
      .set('r_d_fee_apply_before', form.r_d_fee_apply_before)
      .set('ambulance_fee', form.ambulance_fee)
      .set('owner_id', form.owner_id) 
      .set('image', form.image || '')
      .set('about', form.about) 
      .set('registration_detail', form.registration_detail)
      .set('registration_file', form.registration_file)
      .set('accredition_details', form.accredition_details)
      .set('accredition_certificate', JSON.stringify(form.accredition_certificate))
      .set('days', JSON.stringify(form.days));
    return this.http.post(
      BASE_API_URL + 'lab-update-setup-info',
      body,
      httpOptions
    );
  }
  updateLabSetupInfoCp(form: any): Observable<any> {
    const body = new HttpParams()
      .set('name', form.cp_name)
      .set('email', form.email)
      .set('mobile', form.mobile)
      .set('password', form.password);
    return this.http.post(
      BASE_API_URL + 'lab-update-setup-info-cp',
      body,
      httpOptions
    );
  }

  updateNursingProcedureInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '')
      .set('title', form.title)
      .set('price', form.price)
      .set('status', form.status);
    return this.http.post(
      BASE_API_URL + 'update-nursing-procedure-info',
      body,
      httpOptions
    );
  }

  updateLabTestInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '')
      .set('category_id', form.category_id)
      .set('test_name', form.test_name)
      .set('image', form.image || '')
      .set('price', form.price)
      .set('discount', form.discount)
      .set('prerequisite', form.prerequisite)
      .set('home_sample_collection', form.home_sample_collection) 
      .set('ambulance_available', form.ambulance_available) 
      .set('ambulance_fee', form.ambulance_fee || 0) 
      .set('report_home_delivery', form.report_home_delivery);
    return this.http.post(
      BASE_API_URL + 'update-lab-test-info',
      body,
      httpOptions
    );
  }
  updateBBStockInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '')
      .set('component_name', encodeURIComponent(form.component_name))
      .set('avialablity', form.avialablity)
      .set('available_unit', form.available_unit);
    return this.http.post(
      BASE_API_URL + 'update-bb-stock-info',
      body,
      httpOptions
    );
  }
  updateLabTestPackageInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '')
      .set('test_ids', JSON.stringify(form.test_ids))
      .set('package_name', form.package_name)
      .set('image', form.image || '')
      .set('price', form.price)
      .set('discount', form.discount)
      .set('home_sample_collection', form.home_sample_collection) 
      .set('ambulance_available', form.ambulance_available) 
      .set('ambulance_fee', form.ambulance_fee) 
      .set('report_home_delivery', form.report_home_delivery);
    return this.http.post(
      BASE_API_URL + 'update-lab-test-package-info',
      body,
      httpOptions
    );
  }
  updateBlogInfoUser(form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '')
      .set('image', form.image || '')
      .set('title', form.title)
      .set('date', form.date)
      .set('desc', form.desc);
    return this.http.post(
      BASE_API_URL + 'update-blog-info-user',
      body,
      httpOptions
    );
  }
  submitBlogComment(form: any): Observable<any> {
    const body = new HttpParams()
      .set('blog_id', form.blog_id)
      .set('name', form.name)
      .set('email', form.email)
      .set('comment', form.comment);
    return this.http.post(
      BASE_API_URL + 'submit-blog-comment',
      body,
      httpOptions
    );
  }
  getTreatmentList(id: any): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-treatement-list',
      body,
      httpOptions
    );
  }
  updateTreatmentInfo(form: any): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '')
      .set('doctor_id', form.doctor_id || '')
      .set('hospital_id', form.hospital_id || '')
      .set('speciality_id', form.speciality_id || '')
      .set('illness', form.illness || '')
      .set('package_name', form.package_name)
      .set('package_location', form.package_location)
      .set('hospital_name', form.hospital_name)
      .set('hospital_address', form.hospital_address)
      .set('stay_type', form.stay_type)
      .set('charges_in_rs', form.charges_in_rs)
      .set('discount_in_rs', form.discount_in_rs)
      .set('charges_in_doller', form.charges_in_doller || '')
      .set('discount_in_doller', form.discount_in_doller || '')
      .set('details', form.details);
    return this.http.post(
      BASE_API_URL + 'update-treatement-info',
      body,
      httpOptions
    );
  }

  getDocAppointment(doc_id: any = '', type:any = 'Online'): Observable<any> {
    return this.http.get(
      BASE_API_URL + 'get-doc-appointment?doc_id=' + doc_id + '&type='+type,
      httpOptions
    );
  }
  getBlogList(slug: any = '', type: any = '', skip:any = '', limit:any = ''): Observable<any> {
    return this.http.get(
      BASE_API_URL + 'get-blog-list?type=' + type + '&slug=' + slug+ '&skip=' + skip+ '&limit=' + limit,
      httpOptions
    );
  }
  getDocListForHospital(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-doc-list-for-hospital',
      body,
      httpOptions
    );
  }
  getBlogListUser(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-blog-list-user',
      body,
      httpOptions
    );
  }
  getTestListForLab(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-test-list-for-lab',
      body,
      httpOptions
    );
  }
  getNursingProcedure(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-nursing-procedure',
      body,
      httpOptions
    );
  }
  getNursingProcedureAll(id: any = '', nid:any = ''): Observable<any> {
    const body = new HttpParams().set('id', id).set('nid', nid);
    return this.http.post(
      BASE_API_URL + 'get-nursing-procedure-all',
      body,
      httpOptions
    );
  }
  getStockListForBB(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-stock-list-for-bb',
      body,
      httpOptions
    );
  }
  getTestPackageListForLab(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-test-package-list-for-lab',
      body,
      httpOptions
    );
  }
  takeActionOnAppointment(id: any, type: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id).set('type', type);
    return this.http.post(
      BASE_API_URL + 'doc-appointment-action',
      body,
      httpOptions
    );
  }
  takeActionOnCompAppointment(id: any, date: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id).set('date', date);
    return this.http.post(
      BASE_API_URL + 'doc-appointment-action-complete',
      body,
      httpOptions
    );
  }

  getTimeslots(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(BASE_API_URL + 'get-doc-timeslot', body, httpOptions);
  }
  deleteSlot(id: any): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'delete-doc-timeslot',
      body,
      httpOptions
    );
  }
  addSlot(form: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '')
      .set('day', JSON.stringify(form.day))
      .set('slot_interval', form.slot_interval)
      .set('shift1_start_at', form.shift1_start_at)
      .set('shift1_end_at', form.shift1_end_at)
      .set('shift2_start_at', form.shift2_start_at)
      .set('shift2_end_at', form.shift2_end_at);
    return this.http.post(BASE_API_URL + 'add-doc-timeslot', body, httpOptions);
  }

  getProfileInfo(url: any): Observable<any> {
    const body = new HttpParams().set('s', url);
    return this.http.post(BASE_API_URL + 'i-f-profile', body, httpOptions);
  }
  updateDocSetupInfo(form: any, doc_id: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('doc_id', doc_id)
      .set('full_name', form.full_name)
      .set('gender', form.gender)
      .set('degree_file', form.degree_file)
      .set('working_days', JSON.stringify(form.working_days))
      .set('password', form.password || '')
      .set('email', form.email || '')
      .set('mobile', form.mobile || '')
      .set('l_h_image', form.l_h_image || '')
      .set('l_h_sign', form.l_h_sign || '')
      .set('doctor_image', form.doctor_image || '')
      .set('doctor_banner', form.doctor_banner || '')
      .set('home_visit', form.home_visit)
      .set('consultancy_fee', form.consultancy_fee)
      .set('home_consultancy_fee', form.home_consultancy_fee)
      .set('online_consultancy_fee', form.online_consultancy_fee)
      .set('designation', form.designation)
      .set('about', form.about)
      .set('experience', form.experience)
      .set('registration_details', form.registration_details)
      .set('registration_certificate', form.registration_certificate)
      .set('medical_counsiling', form.medical_counsiling)
      .set('letterhead', form.letterhead)
      .set('is_deleted', form.is_deleted || '')
      .set('signature', form.signature);
    return this.http.post(
      BASE_API_URL + 'doc-update-setup-info',
      body,
      httpOptions
    );
  }
  updateDocSetupInfoSS(form: any, doc_id: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('doc_id', doc_id)
      .set('symptom_i_see', JSON.stringify(form.symptom_i_see))
      .set('deasies_i_treat', JSON.stringify(form.deasies_i_treat))
      .set('treatment_and_surgery', JSON.stringify(form.treatment_and_surgery))
      .set('specialization_id', JSON.stringify(form.specialization_id))
      .set('specialities_id', JSON.stringify(form.specialities_id));
    return this.http.post(
      BASE_API_URL + 'doc-update-setup-info-ss',
      body,
      httpOptions
    );
  }
  updateDocSetupInfoAward(form: any, doc_id: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('award', form.award)
      .set('memberships_detail', form.memberships_detail)
      .set('doc_id', doc_id);
    return this.http.post(
      BASE_API_URL + 'doc-update-setup-info-award',
      body,
      httpOptions
    );
  }
  updateDocSetupInfoBank(form: any, doc_id: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('doc_id', doc_id)
      .set('name', form.name)
      .set('bank_name', form.bank_name)
      .set('branch_name', form.branch_name)
      .set('ifsc', form.ifsc)
      .set('ac_no', form.ac_no)
      .set('ac_type', form.ac_type)
      .set('micr_code', form.micr_code || '')
      .set('cancel_cheque', form.cancel_cheque || '')
      .set('pan_no', form.pan_no)
      .set('pan_image', form.pan_image || '');
    return this.http.post(
      BASE_API_URL + 'doc-update-setup-info-bank',
      body,
      httpOptions
    );
  }
  updateHosSetupInfoBank(form: any, doc_id: any = ''): Observable<any> {
    const body = new HttpParams() 
      .set('name', form.name)
      .set('bank_name', form.bank_name)
      .set('branch_name', form.branch_name)
      .set('ifsc', form.ifsc)
      .set('ac_no', form.ac_no)
      .set('ac_type', form.ac_type)
      .set('micr_code', form.micr_code || '')
      .set('cancel_cheque', form.cancel_cheque || '')
      .set('pan_no', form.pan_no)
      .set('pan_image', form.pan_image || '');
    return this.http.post(
      BASE_API_URL + 'hospital-update-setup-info-bank',
      body,
      httpOptions
    );
  }
  updateDocInfoForSetupEdu(form: any, doc_id: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('doc_id', doc_id)
      .set('qualification_id', form.qualification_id)
      .set('certificate', form.certificate);
    return this.http.post(
      BASE_API_URL + 'doc-update-setup-info-edu',
      body,
      httpOptions
    );
  }
  getSpecialities(
    city: any = '',
    specialization_id: any = ''
  ): Observable<any> {
    const body = new HttpParams()
      .set('city', JSON.stringify(city))
      .set('specialization_id', specialization_id);
    return this.http.post(BASE_API_URL + 'specialities', body, httpOptions);
  }
  getAddressInfo(
    address_type: any = '',
    updating_for: any = ''
  ): Observable<any> {
    const body = new HttpParams()
      .set('address_type', address_type)
      .set('updating_for', updating_for);
    return this.http.post(BASE_API_URL + 'get-address-info', body, httpOptions);
  }
  updateAddressInfo(
    form: any = ''
  ): Observable<any> {
    const body = new HttpParams()
      .set('address_type', form.address_type)
      .set('updating_for', form.updating_for)
      .set('address', form.full_address) 
      .set('city', form.city) 
      .set('pincode', form.pincode) 
      .set('country', form.country) 
      .set('latitude', form.latitude) 
      .set('longitude', form.longitude);
    return this.http.post(BASE_API_URL + 'update-address-info', body, httpOptions);
  }
  getLabTestCategory(city: any = '', id: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('city', JSON.stringify(city))
      .set('id', id);
    return this.http.post(
      BASE_API_URL + 'lab-test-category',
      body,
      httpOptions
    );
  }
  getLabTestTop(city: any = ''): Observable<any> {
    const body = new HttpParams().set('city', JSON.stringify(city));
    return this.http.post(BASE_API_URL + 'lab-test-top', body, httpOptions);
  }
  getProcedures(city: any = ''): Observable<any> {
    const body = new HttpParams().set('city', JSON.stringify(city));
    return this.http.post(BASE_API_URL + 'procedures', body, httpOptions);
  }
  getFacilities(city: any = ''): Observable<any> {
    const body = new HttpParams().set('city', JSON.stringify(city));
    return this.http.post(BASE_API_URL + 'facilities', body, httpOptions);
  }
  getSpecialization(city: any = ''): Observable<any> {
    const body = new HttpParams().set('city', JSON.stringify(city));
    return this.http.post(BASE_API_URL + 'specialization', body, httpOptions);
  }
  getDesignation(title: any = ''): Observable<any> {
    const body = new HttpParams().set('title', title);
    return this.http.post(BASE_API_URL + 'get-designation', body, httpOptions);
  }
  getAllLabTest(title: any = ''): Observable<any> {
    const body = new HttpParams().set('title', title);
    return this.http.post(BASE_API_URL + 'get-labtest-master', body, httpOptions);
  }
  getBBComponent(title: any = ''): Observable<any> {
    const body = new HttpParams().set('title', title);
    return this.http.post(BASE_API_URL + 'get-bb-component', body, httpOptions);
  }
  getMedicalCounsiling(title: any = ''): Observable<any> {
    const body = new HttpParams().set('title', title);
    return this.http.post(BASE_API_URL + 'get-medical-counsiling', body, httpOptions);
  }

  getDocWFieldList(): Observable<any> {
    return this.http.get(BASE_API_URL + 'doc-w-field-list', httpOptions);
  }
  getPharmacyCategory(city: any = ''): Observable<any> {
    const body = new HttpParams().set('city', JSON.stringify(city));
    return this.http.post(
      BASE_API_URL + 'pharmacy-category',
      body,
      httpOptions
    );
  }
  getPharmacyFormulation(city: any = ''): Observable<any> {
    const body = new HttpParams().set('city', JSON.stringify(city));
    return this.http.post(
      BASE_API_URL + 'pharmacy-formulation',
      body,
      httpOptions
    );
  }
  getPharmacyComposition(city: any = ''): Observable<any> {
    const body = new HttpParams().set('city', JSON.stringify(city));
    return this.http.post(
      BASE_API_URL + 'pharmacy-composition',
      body,
      httpOptions
    );
  }
  getHomeCareReq(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'home-care-orders',
      body,
      httpOptions
    );
  }
  getBueroNurseList(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'my-nursing',
      body,
      httpOptions
    );
  }
  getDealerOrder(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'dealer-orders',
      body,
      httpOptions
    );
  }
  getPharmacyOrder(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'pharmacy-orders',
      body,
      httpOptions
    );
  }
  getTreatmentOrder(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'dr-treatment-orders',
      body,
      httpOptions
    );
  }
  getLabtestOrderUpdate(id: any = '', form:any): Observable<any> {
    const body = new HttpParams().set('id', id).set('is_completed', form.status).set('report_file', form.report_file);
    return this.http.post(
      BASE_API_URL + 'lab-test-orders-update',
      body,
      httpOptions
    );
  }
  updateLabEc(id: any = '', val:any, type:any): Observable<any> {
    const body = new HttpParams().set('id', id).set('value', val).set('type', type);
    return this.http.post(
      BASE_API_URL + 'update-lab-ec',
      body,
      httpOptions
    );
  }
  updatePharmasyEc(id: any = '', val:any, type:any): Observable<any> {
    const body = new HttpParams().set('id', id).set('value', val).set('type', type);
    return this.http.post(
      BASE_API_URL + 'update-pharmasy-ec',
      body,
      httpOptions
    );
  }
  getProductOrderUpdate(id: any = '', form:any): Observable<any> {
    const body = new HttpParams().set('id', id).set('is_completed', form.status).set('type', form.type);
    return this.http.post(
      BASE_API_URL + 'product-orders-update',
      body,
      httpOptions
    );
  }
  getDealerProductOrderUpdate(id: any = '', form:any): Observable<any> {
    const body = new HttpParams().set('id', id).set('status', form.status).set('type', form.type);
    return this.http.post(
      BASE_API_URL + 'dealer-product-orders-update',
      body,
      httpOptions
    );
  }
  getHomeCareUpdate(id: any = '', form:any): Observable<any> {
    const body = new HttpParams().set('id', id).set('status', form.status).set('type', form.type);
    return this.http.post(
      BASE_API_URL + 'home-care-orders-update',
      body,
      httpOptions
    );
  }
  getAmbulanceReqOrderUpdate(id: any = '', form:any): Observable<any> {
    const body = new HttpParams().set('id', id).set('status', form.status).set('type', form.type);
    return this.http.post(
      BASE_API_URL + 'ambulance-orders-update',
      body,
      httpOptions
    );
  }
  getLabtestOrder(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'lab-test-orders',
      body,
      httpOptions
    );
  }
  getAmbulanceReqOrder(id: any = ''): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'ambulance-req-orders',
      body,
      httpOptions
    );
  }
  getPharmacyCategoryWithProduct(city: any = ''): Observable<any> {
    const body = new HttpParams().set('city', JSON.stringify(city));
    return this.http.post(
      BASE_API_URL + 'pharmacy-category-with-product',
      body,
      httpOptions
    );
  }
  getPharmacySubCategory(
    city: any = '',
    category_id: any = ''
  ): Observable<any> {
    const body = new HttpParams()
      .set('city', JSON.stringify(city))
      .set('category_id', category_id);
    return this.http.post(
      BASE_API_URL + 'pharmacy-sub-category',
      body,
      httpOptions
    );
  }
  searchMyProductMedi(
    search: any = '',
    productType:any = ''
  ): Observable<any> {
    const body = new HttpParams() 
      .set('search', search).set('productType', productType);
    return this.http.post(
      BASE_API_URL + 'pharmacy-medi-product',
      body,
      httpOptions
    );
  }
  getPharmacyProductList(
    city: any = '',
    category_id: any = '',
    selectedSubCatList: any = '',
    search:any = '',
    limit:any = '',
    only_id:any = '',
    salt_name:any = ''
  ): Observable<any> {
    const body = new HttpParams()
      .set('city', JSON.stringify(city))
      .set('sub_cat', JSON.stringify(selectedSubCatList))
      .set('q', search)
      .set('category_id', category_id)
      .set('only_id', only_id)
      .set('salt_name', salt_name)
      .set('limit', limit);
    return this.http.post(
      BASE_API_URL + 'pharmacy-products',
      body,
      httpOptions
    );
  }
  getPharmacyProductInfo(slug: any = ''): Observable<any> {
    const body = new HttpParams().set('slug', slug);
    return this.http.post(
      BASE_API_URL + 'pharmacy-products-info',
      body,
      httpOptions
    );
  }
  buyCartInfo(cart: any ): Observable<any> {
    const body = new HttpParams().set('cart', JSON.stringify(cart));
    return this.http.post(
      BASE_API_URL + 'buy-cart-info',
      body,
      httpOptions
    );
  }
  getCartInfo(cart: any ): Observable<any> {
    const body = new HttpParams().set('cart', JSON.stringify(cart));
    return this.http.post(
      BASE_API_URL + 'get-cart-info',
      body,
      httpOptions
    );
  }
  getMyPharmacyProduct(id: any = '', productType:any = ''): Observable<any> {
    const body = new HttpParams().set('id', id).set('productType', productType);
    return this.http.post(
      BASE_API_URL + 'my-pharmacy-products',
      body,
      httpOptions
    );
  }
  searchPharmacyProduct(title: any = ''): Observable<any> {
    const body = new HttpParams().set('title', title);
    return this.http.post(
      BASE_API_URL + 'search-pharmacy-products',
      body,
      httpOptions
    );
  }
  addMyPharmacyProduct(form: any = '', productType:any = ''): Observable<any> {
    const body = new HttpParams()
      .set('productType', productType)
      .set('id', form.id || '')
      .set('variant_name', form.variant_name)
      .set('mrp', form.mrp)
      .set('discount', form.discount)
      .set('strength', form.strength)
      .set('image', form.image || '')
      .set('image_2', form.image_2 || '')
      .set('image_3', form.image_3 || '')
      .set('image_4', form.image_4 || '')
      .set('category_id', form.category_id)
      // .set('sub_category_id', form.sub_category_id)
      .set('title', form.title)
      .set('manufacturer_name', form.manufacturer_name)
      .set('formulation_id', form.formulation_id)
      .set('avaliblity', form.avaliblity)
      .set('prescription_required', form.prescription_required)
      // .set('benefits', form.benefits)
      // .set('ingredients', form.ingredients)
      // .set('uses', form.uses)
      .set('description', form.description)
      .set('expiry_type', form.expiry_type || '')
      .set('expiry_month', form.expiry_month || '')
      .set('expiry_year', form.expiry_year || '')
      .set('salt_name', form.salt_name || '')
      .set('manufacturer_address', form.manufacturer_address)
      .set('copy_from', form.copy_from || '')
      .set('brand_name', form.brand_name);
    return this.http.post(
      BASE_API_URL + 'add-my-pharmacy-products',
      body,
      httpOptions
    );
  }
  addMyPharmacyProductMrp(form: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '')
      .set('product_id', form.product_id)
      .set('mrp', form.mrp)
      .set('discount', form.discount)
      .set('p_name', form.p_name)
      .set('description', form.description);
    return this.http.post(
      BASE_API_URL + 'add-my-pharmacy-products-mrp',
      body,
      httpOptions
    );
  }
  addMyPharmacyProductImg(form: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('id', form.id || '')
      .set('product_id', form.product_id)
      .set('file_name', form.attachment);
    return this.http.post(
      BASE_API_URL + 'add-my-pharmacy-products-img',
      body,
      httpOptions
    );
  }
  getSpecialitiesTopDoc(city: any, sid: any = ''): Observable<any> {
    const body = new HttpParams()
      .set('city', JSON.stringify(city))
      .set('sid', sid);
    return this.http.post(
      BASE_API_URL + 'specialities-top-doc',
      body,
      httpOptions
    );
  }
  getBloodbankList(
    city: any = '',
    hospital_id: any = '',
    price_order: any = '',
    search:any = '',
    searchStringSub:any = ''
  ): Observable<any> {
    const body = new HttpParams()
      .set('city', JSON.stringify(city))
      .set('hospital_id', hospital_id)
      .set('price_order', price_order)
      .set('search', search).set('sub_cat', searchStringSub);
    return this.http.post(BASE_API_URL + 'bloodbank', body, httpOptions);
  }
  getAmbulanceAllList(
    city: any = '', 
    search:any = '',
    type:any = '',
    searchBy:any = '',
    searchStringSub:any = ''
  ): Observable<any> {
    const body = new HttpParams()
      .set('city', JSON.stringify(city))
      .set('search', search).set('sub_cat', searchStringSub).set('type', type).set('searchBy', searchBy);
    return this.http.post(BASE_API_URL + 'ambulance', body, httpOptions);
  }
  getDoctorList(
    city: any = '',
    speciality_id: any = '',
    selected_gender: any = '',
    price_order: any = '',
    search : any = '',
    searchBy : any = '',
    searchBy2 : any = '',
  ): Observable<any> {
    const body = new HttpParams()
      .set('city', JSON.stringify(city))
      .set('speciality_id', speciality_id)
      .set('selected_gender', selected_gender)
      .set('price_order', price_order)
      .set('search', search)
      .set('searchBy', searchBy)
      .set('sub_cat', searchBy2);
    return this.http.post(BASE_API_URL + 'doctors', body, httpOptions);
  }
  getNursingList(
    city: any = '', 
    id: any = '',
    price_order: any = '',
    search:any = '',
    sub:any = ''
  ): Observable<any> {
    const body = new HttpParams()
      .set('city', JSON.stringify(city)) 
      .set('id', id).set('price_order', price_order).set('q', search).set('sub_cat', sub);
    return this.http.post(BASE_API_URL + 'nursing', body, httpOptions);
  }
  getDoctorInfo(slug: any, id:any = ''): Observable<any> {
    const body = new HttpParams().set('slug', slug).set('id', id);
    return this.http.post(BASE_API_URL + 'doctors', body, httpOptions);
  }
 
  getFamilyPatient(id: any = '', type:any = ''): Observable<any> {
    const body = new HttpParams().set('id', id).set('type', type);
    return this.http.post(
      BASE_API_URL + 'get-family-patient',
      body,
      httpOptions
    );
  }
  getBloodbankInfo(slug: any): Observable<any> {
    const body = new HttpParams().set('slug', slug);
    return this.http.post(BASE_API_URL + 'bloodbank', body, httpOptions);
  }
  getAmbulanceServiceProvider(slug: any): Observable<any> {
    const body = new HttpParams().set('slug', slug);
    return this.http.post(BASE_API_URL + 'ambulance', body, httpOptions);
  }
  getAutouggestion(cat: any, sub_cat:any, search:any = ''): Observable<any> {
    const body = new HttpParams().set('cat', cat).set('sub_cat', sub_cat).set('search', search);
    return this.http.post(BASE_API_URL + 'auto-suggestion', body, httpOptions);
  }
  getLabList(city: any = '', search:any = '', searchBy:any = '',searchStringSub:any = ''): Observable<any> {
    const body = new HttpParams().set('city', JSON.stringify(city)).set('search', search).set('searchBy', searchBy).set('sub_cat', searchStringSub);
    return this.http.post(BASE_API_URL + 'labs', body, httpOptions);
  }
  getLabInfo(slug: any): Observable<any> {
    const body = new HttpParams().set('slug', slug);
    return this.http.post(BASE_API_URL + 'labs', body, httpOptions);
  }
  getHospitalList(city: any = '', search:any = '', searchStringSub:any = ''): Observable<any> {
    const body = new HttpParams().set('city', JSON.stringify(city)).set('search', search).set('sub_cat', searchStringSub);
    return this.http.post(BASE_API_URL + 'hospitals', body, httpOptions);
  }
  getHospitalInfo(slug: any): Observable<any> {
    const body = new HttpParams().set('slug', slug);
    return this.http.post(BASE_API_URL + 'hospitals', body, httpOptions);
  }
  getHospitalDoc(hospital_id: any): Observable<any> {
    const body = new HttpParams().set('hospital_id', hospital_id);
    return this.http.post(BASE_API_URL + 'doctors', body, httpOptions);
  }
  getHospitalTreatment(hospital_id: any): Observable<any> {
    const body = new HttpParams().set('hospital_id', hospital_id);
    return this.http.post(BASE_API_URL + 'get-treatement-list-of-hospitals', body, httpOptions);
  }

  submitContactUsForm(form: any = []): Observable<any> {
    const body = new HttpParams()
      .set('name', form.name)
      .set('email', form.email)
      .set('mobile', form.mobile)
      .set('address', form.address)
      .set('message', form.message)
      .set('source', form.source)
      .set('page', form.page);
    return this.http.post(BASE_API_URL + 'lead-form', body, httpOptions);
  }
  submitContactUsFormUsers(form: any = []): Observable<any> {
    const body = new HttpParams()
      .set('name', form.name)
      .set('email', form.email)
      .set('mobile', form.mobile)
      .set('subject', form.subject)
      .set('message', form.message)
      .set('to_user_id', form.to_user_id)
      .set('url', form.url);
    return this.http.post(BASE_API_URL + 'i-f-lead-form', body, httpOptions);
  }
  submitNewsletterForm(form: any = []): Observable<any> {
    const body = new HttpParams()
      .set('email', form.email)
      .set('source', form.source)
      .set('page', form.page);
    return this.http.post(BASE_API_URL + 'lead-form', body, httpOptions);
  }
  
  orderResponse(data: any, req_id:any,type:any): Observable<any> {
    const body = new HttpParams()
      .set('type', type)
      .set('req_id', req_id)
      .set('name', data.name)
      .set('image', data.image || '')
      .set('amount', data.amount)
      .set('currency', data.currency)
      .set('description', data.description)
      .set('order_id', data.order_id)
      .set('notes', JSON.stringify(data.notes))
      .set('prefill', JSON.stringify(data.prefill))
      .set('response', JSON.stringify(data.response));
    return this.http.post(
      BASE_API_URL + 'payment-response',
      body,
      httpOptions
    );
  }
  createOrder(amount:any): Observable<any> {
    const body = new HttpParams().set('amount', amount);
    return this.http.post(BASE_API_URL + 'create-payment', body, httpOptions);
  }
  getLatLngPincode(pincode: any): Observable<any> {
    const body = new HttpParams()
      .set('pincode', pincode);
    return this.http.post(
      BASE_API_URL + 'get-pincode',
      body,
      httpOptions
    );
  } 
  getListingChargesInfo(id: any): Observable<any> {
    const body = new HttpParams().set('id', id);
    return this.http.post(
      BASE_API_URL + 'get-listing-info',
      body,
      httpOptions
    );
  } 
  validateCode(code: any): Observable<any> {
    const body = new HttpParams().set('code', code);
    return this.http.post(
      BASE_API_URL + 'validate-coupon',
      body,
      httpOptions
    );
  } 
  getServiceInfo(id: any): Observable<any> {
    const body = new HttpParams().set('service_id', id);
    return this.http.post(
      BASE_API_URL + 'get-service-info',
      body,
      httpOptions
    );
  } 
 
}
