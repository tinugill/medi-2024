<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\HospitalController;
use App\Http\Controllers\api\DoctorController;
use App\Http\Controllers\api\SpecialitiesController;
use App\Http\Controllers\api\AppointmentController;
use App\Http\Controllers\api\GeneralController;
use App\Http\Controllers\api\LabController;
use App\Http\Controllers\api\TimeslotController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'customer'], function () {
    Route::post('login', [UserController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
    });
});

Route::group(['prefix' => 'customer'], function () {
    Route::post('verify-otp-signup', [DoctorController::class, 'signupVerifyOtp']);
});
Route::group(['prefix' => 'customer'], function () {
    Route::post('send-otp-forget-password', [DoctorController::class, 'forgetPassSendOtp']);
});
Route::group(['prefix' => 'customer'], function () {
    Route::post('verify-otp-forget-password', [DoctorController::class, 'verifyPassSendOtp']);
});
Route::group(['prefix' => 'customer'], function () {
    Route::post('signup-user', [DoctorController::class, 'customerSignup']);
});

Route::post('create-payment', [PaymentController::class, 'createOrder']);
Route::post('payment-response', [PaymentController::class, 'razorpayResponse']);

Route::get('temp-image', [DoctorController::class, 'uploadTempImages']);
Route::get('get-doc-info', [DoctorController::class, 'docInfoForSetup']);
Route::get('doc-w-field-list', [DoctorController::class, 'getDocWFieldList']);
Route::post('get-doc-list-for-hospital', [DoctorController::class, 'docListForHospital']);
Route::post('doc-update-setup-info', [DoctorController::class, 'updateDocInfoForSetup']);
Route::post('doc-update-setup-info-ss', [DoctorController::class, 'updateDocInfoForSetupSS']);
Route::post('doc-update-setup-info-award', [DoctorController::class, 'updateDocInfoForSetupAward']);
Route::post('doc-update-setup-info-bank', [DoctorController::class, 'updateDocInfoForSetupBank']);
Route::post('hospital-update-setup-info-bank', [DoctorController::class, 'updateHosInfoForSetupBank']);
Route::post('doc-update-setup-info-edu', [DoctorController::class, 'updateDocInfoForSetupEdu']);

Route::post('get-family-patient', [DoctorController::class, 'getFamilyPatients']);
Route::post('add-family-member', [DoctorController::class, 'addFamilyPatients']);

Route::post('hospitals', [HospitalController::class, 'hospitalList']);
Route::get('get-hosp-info', [HospitalController::class, 'hospInfoForSetup']);
Route::post('hosp-update-setup-info', [HospitalController::class, 'updateHospInfoForSetup']);
Route::post('hosp-update-setup-info-cp', [HospitalController::class, 'updateHospInfoForSetupCp']);

Route::get('get-blog-list', [LabController::class, 'getBlogList']);
Route::post('get-blog-list-user', [LabController::class, 'getBlogListUser']);
Route::post('update-blog-info-user', [LabController::class, 'updateBlogInfo']);
Route::post('submit-blog-comment', [LabController::class, 'submitBlogComment']);

Route::get('get-illness-list', [DoctorController::class, 'getIllnessList']);
Route::post('get-treatement-list', [DoctorController::class, 'getTreatmentList']);
Route::post('get-treatement-list-of-hospitals', [DoctorController::class, 'getTreatmentListByHospital']);
Route::post('update-treatement-info', [DoctorController::class, 'updateTreatments']);

Route::get('get-bloodbank-info', [LabController::class, 'bloodbankInfoForSetup']);
Route::post('bloodbank-update-setup-info', [LabController::class, 'updateBloodbankInfoForSetup']);
Route::post('bloodbank-update-setup-info-cp', [LabController::class, 'updateBloodbankInfoForSetupCp']);

Route::post('get-stock-list-for-bb', [LabController::class, 'getBloodbankStock']);
Route::post('update-bb-stock-info', [LabController::class, 'updateBloodbankStock']);

Route::post('get-dealer-eqp-category', [ProductController::class, 'getDealerEqpCategory']);
Route::post('get-dealer-product-list', [LabController::class, 'getDealerProductList']);
Route::post('update-dealer-product-info', [LabController::class, 'updateDealerProductInfo']);


Route::post('nursing', [LabController::class, 'nursingList']);
Route::post('my-nursing', [LabController::class, 'myNursingList']);
Route::get('get-nursing-info', [LabController::class, 'nursingInfoForSetup']);
Route::post('nursing-update-setup-info', [LabController::class, 'updateNursingInfoForSetup']);
Route::post('nursing-update-setup-info-cp', [LabController::class, 'updateNursingInfoForSetupCp']);
Route::post('nursing-update-setup-info-bank', [LabController::class, 'updateNursingInfoForSetupBk']);

Route::get('get-dealer-info', [LabController::class, 'dealerInfoForSetup']);
Route::get('get-amb-info', [LabController::class, 'ambInfoForSetup']);
Route::post('dealer-update-setup-info', [LabController::class, 'updateDealerInfoForSetup']);
Route::post('amb-update-setup-info', [LabController::class, 'updateAmbInfoForSetup']);
Route::post('dealer-update-setup-info-cp', [LabController::class, 'updateDealerInfoForSetupCp']);
Route::post('amb-update-setup-info-cp', [LabController::class, 'updateAmbInfoForSetupCp']);
Route::post('dealer-update-setup-info-bank', [LabController::class, 'updateDealerInfoForSetupBk']);
Route::post('amb-update-setup-info-bank', [LabController::class, 'updateAmbInfoForSetupBk']);
Route::post('get-executive', [LabController::class, 'getMyExecutive']);
Route::post('get-my-ambulance-list', [LabController::class, 'getMyAmbulanceList']);
Route::post('get-my-ambulance-driver-list', [LabController::class, 'getMyAmbulanceDriverList']);
Route::post('update-ambulance-list', [LabController::class, 'updateMyAmbulanceInfo']);
Route::post('update-executive', [LabController::class, 'updateExecutive']);
Route::post('update-ambulance-deiver-list', [LabController::class, 'updateMyAmbulanceDriverInfo']);


Route::get('get-pharmacy-info', [LabController::class, 'parmacyInfoForSetup']);
Route::post('pharmacy-update-setup-info', [LabController::class, 'updatePharmacyInfoForSetup']);
Route::post('pharmacy-update-setup-info-cp', [LabController::class, 'updatePharmacyInfoForSetupCp']);
Route::post('pharmacy-update-setup-info-bank', [LabController::class, 'updatePharmacyInfoForSetupBk']);

Route::get('get-lab-info', [LabController::class, 'labInfoForSetup']);
Route::post('lab-update-setup-info', [LabController::class, 'updateLabInfoForSetup']);
Route::post('lab-update-setup-info-cp', [LabController::class, 'updateLabInfoForSetupCp']);
Route::post('lab-update-setup-info-bank', [LabController::class, 'updateLabInfoForSetupBk']);
Route::post('get-test-list-for-lab', [LabController::class, 'testListForLab']);
Route::post('get-nursing-procedure', [LabController::class, 'listNursingProcedure']);
Route::post('get-nursing-procedure-all', [LabController::class, 'listNursingProcedureAll']);
Route::post('get-test-package-list-for-lab', [LabController::class, 'testPackageListForLab']);
Route::post('update-lab-test-info', [LabController::class, 'updateLabTestForLab']);
Route::post('update-nursing-procedure-info', [LabController::class, 'updateNursingProcedure']);
Route::post('update-lab-test-package-info', [LabController::class, 'updateLabTestPackageForLab']);

Route::post('doctors', [DoctorController::class, 'doctorList']);
Route::post('bloodbank-donation-complete', [LabController::class, 'bbDonationComplete']);
Route::post('bloodbank-donation-form', [LabController::class, 'bbDonationForm']);
Route::post('ambulance-booking-form', [LabController::class, 'ambulanceBookingForm']);
Route::get('get-bloodbank-donation-req', [LabController::class, 'bbDonationReq']);
Route::post('bloodbank', [LabController::class, 'bbList']);
Route::post('ambulance', [LabController::class, 'ambulanceList']);
Route::post('labs', [LabController::class, 'labList']);
Route::post('lab-test-category', [LabController::class, 'labTestCategory']);
Route::post('lab-test-top', [LabController::class, 'labTestTop']);
Route::post('facilities', [SpecialitiesController::class, 'facilitiesList']);
Route::post('procedures', [SpecialitiesController::class, 'proceduresList']);
Route::post('specialization', [SpecialitiesController::class, 'specializationList']);
Route::post('specialities', [SpecialitiesController::class, 'specialitiesList']);
Route::post('specialities-top-doc', [SpecialitiesController::class, 'specialitiesTopDoc']);
Route::post('appointment', [AppointmentController::class, 'appointmentAdd']);
Route::post('appointment-labtest', [AppointmentController::class, 'appointmentAddLabtest']);
Route::post('book-dealer-product', [AppointmentController::class, 'bookDealerProduct']);
Route::post('book-home-care', [AppointmentController::class, 'bookHomeCare']);

Route::post('get-cart-info', [AppointmentController::class, 'cartInfo']);
Route::post('buy-cart-info', [AppointmentController::class, 'buyCartInfo']);
Route::get('get-doc-appointment', [AppointmentController::class, 'docAppointments']);
Route::post('doc-appointment-action', [AppointmentController::class, 'takeActionOnAppointments']);
Route::post('doc-appointment-action-complete', [AppointmentController::class, 'takeActionOnAppointmentsComplete']);

Route::post('get-doc-timeslot', [TimeslotController::class, 'docTimeslot']);
Route::post('delete-doc-timeslot', [TimeslotController::class, 'deleteSlot']);
Route::post('add-doc-timeslot', [TimeslotController::class, 'addSlot']);

Route::post('pharmacy-formulation', [ProductController::class, 'getFormulation']);
Route::post('pharmacy-composition', [ProductController::class, 'getComposition']);
Route::post('pharmacy-category', [ProductController::class, 'getCategory']);
Route::post('pharmacy-category-with-product', [ProductController::class, 'getCategoryWithProduct']);
Route::post('pharmacy-sub-category', [ProductController::class, 'getSubCategory']);
Route::post('pharmacy-products-info', [ProductController::class, 'getProducts']);
Route::post('pharmacy-products', [ProductController::class, 'getProducts']);
Route::post('pharmacy-medi-product', [ProductController::class, 'getMediProducts']);
Route::post('my-pharmacy-products', [ProductController::class, 'getMyProducts']);
Route::post('search-pharmacy-products', [ProductController::class, 'searchMyProducts']);
Route::post('add-my-pharmacy-products', [ProductController::class, 'addMyProducts']);

Route::post('dealer-orders', [OrderController::class, 'ordersDealer']);
Route::post('home-care-orders', [OrderController::class, 'ordersHomeCare']);
Route::post('pharmacy-orders', [OrderController::class, 'orders']);
Route::post('dr-treatment-orders', [OrderController::class, 'treatmentOrder']);
Route::post('ambulance-req-orders', [OrderController::class, 'ambulanceOrder']);
Route::post('lab-test-orders', [OrderController::class, 'labtestOrder']);
Route::post('lab-test-orders-update', [OrderController::class, 'labtestOrderUpdate']);
Route::post('update-lab-ec', [OrderController::class, 'updateLabEc']);
Route::post('update-pharmasy-ec', [OrderController::class, 'updatePharmasyEc']);
Route::post('product-orders-update', [OrderController::class, 'productOrderUpdate']);
Route::post('dealer-product-orders-update', [OrderController::class, 'dealerProductOrderUpdate']);
Route::post('home-care-orders-update', [OrderController::class, 'homeCareOrderUpdate']);
Route::post('ambulance-orders-update', [OrderController::class, 'ambulanceOrderUpdate']);

Route::post('auto-suggestion', [GeneralController::class, 'autoSuggestion']);
Route::post('get-designation', [GeneralController::class, 'getDesignation']);
Route::post('get-address-info', [GeneralController::class, 'getAddressInfo']);
Route::post('update-address-info', [GeneralController::class, 'updateAddressInfo']);
Route::post('get-labtest-master', [GeneralController::class, 'getLabtestMaster']);
Route::post('get-bb-component', [GeneralController::class, 'getBBComponent']);
Route::post('get-medical-counsiling', [GeneralController::class, 'getMedicalCounsiling']);
Route::get('get-appointment', [AppointmentController::class, 'appointmentList']);
Route::post('send-message-apn', [OrderController::class, 'sendMessage']);
Route::post('get-message-apn', [OrderController::class, 'getMessage']);
Route::post('create-video-link', [OrderController::class, 'createVideoLink']);
Route::post('update-zoom-details', [OrderController::class, 'updateMeetingSecret']);
Route::post('get-zoom-details', [OrderController::class, 'getVideoLink']);
Route::get('zoom-verify', [OrderController::class, 'zoomVerify']);
Route::get('zoom-refresh', [OrderController::class, 'refreshToken']);
Route::post('get-pincode', [AppointmentController::class, 'getLatLngByPincode']);
Route::post('get-apn-comment', [AppointmentController::class, 'getApnComment']);
Route::post('add-apn-comment', [AppointmentController::class, 'addApnComment']);
Route::post('add-apn-comment-file-only', [AppointmentController::class, 'addApnCommentFileOnly']);
Route::post('get-apn-medicien', [AppointmentController::class, 'getApnMedi']);
Route::post('add-apn-medicien', [AppointmentController::class, 'addApnMedi']);
Route::post('get-diagnosis-list', [GeneralController::class, 'getDignosisList']);
Route::post('report-chat', [GeneralController::class, 'reportChat']);
Route::post('get-listing-info', [GeneralController::class, 'getListingChargesInfo']);
Route::post('get-service-info', [GeneralController::class, 'getServiceInfo']);
Route::post('review-submit-action', [GeneralController::class, 'reviewSubmitAction']);
Route::post('get-all-reviews', [GeneralController::class, 'getAllReviews']);
Route::post('review-get-single-action', [GeneralController::class, 'getSingleReviews']);
Route::get('get-ambulance-type-list', [GeneralController::class, 'getAmbType']);
Route::post('validate-coupon', [GeneralController::class, 'validateCoupon']);
