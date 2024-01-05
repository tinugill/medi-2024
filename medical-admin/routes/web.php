<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\AuthController;
use App\Http\Controllers\Superadmin\ProceduresController;
use App\Http\Controllers\Superadmin\SpecializationController;
use App\Http\Controllers\Superadmin\SpecialitiesController;
use App\Http\Controllers\Superadmin\HospitalController;
use App\Http\Controllers\Superadmin\HospitalStaffController;
use App\Http\Controllers\Superadmin\DoctorController;
use App\Http\Controllers\Superadmin\PharmacistController;
use App\Http\Controllers\Superadmin\LaboratoristController;
use App\Http\Controllers\Superadmin\CustomerController;
use App\Http\Controllers\Superadmin\PharmacyController;
use App\Http\Controllers\Superadmin\ProductController;
use App\Http\Controllers\Superadmin\CategoryController;
use App\Http\Controllers\Superadmin\CategoryEqpController;
use App\Http\Controllers\Superadmin\ServicePaymentController;
use App\Http\Controllers\Superadmin\SubCategoryController;
use App\Http\Controllers\Superadmin\LabtestcategoryController;
use App\Http\Controllers\Superadmin\LabtestController;
use App\Http\Controllers\Superadmin\LabtestpackageController;
use App\Http\Controllers\Superadmin\BloodbankController;
use App\Http\Controllers\Superadmin\BloodbankstockController;
use App\Http\Controllers\Superadmin\DesignationController;
use App\Http\Controllers\Superadmin\MedicalCounsilingController;
use App\Http\Controllers\Superadmin\IllnessListController;
use App\Http\Controllers\Superadmin\TreatmentListController;
use App\Http\Controllers\Superadmin\SymptomListController;
use App\Http\Controllers\Superadmin\LabtestmasterController;
use App\Http\Controllers\Superadmin\FacilityController;
use App\Http\Controllers\Superadmin\EmpanelmentsController;
use App\Http\Controllers\Superadmin\DignosisController;
use App\Http\Controllers\Superadmin\NursingController;
use App\Http\Controllers\Superadmin\AmbulanceController;
use App\Http\Controllers\Superadmin\AmbulanceTypeController;
use App\Http\Controllers\Superadmin\CompositionController;
use App\Http\Controllers\Superadmin\DealerController;
use App\Http\Controllers\Superadmin\ListingDiscountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('superadmin.index');
});

//route for superadmin
Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], '/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');


///Procedures route
Route::resource('designation', DesignationController::class);


Route::resource('medical_counsling', MedicalCounsilingController::class);
Route::resource('illness_list', IllnessListController::class);
Route::resource('treatment_list', TreatmentListController::class);
Route::resource('symptom_list', SymptomListController::class);
Route::resource('listing_discount_list', ListingDiscountController::class);
Route::resource('labtest_masterdb', LabtestmasterController::class);
Route::resource('facility_list', FacilityController::class);
Route::resource('empanelments_list', EmpanelmentsController::class);
Route::resource('dignosis_list', DignosisController::class);


///Procedures route
Route::resource('procedures', ProceduresController::class);

//specialization
Route::resource('specialization', SpecializationController::class);

//Specialities
Route::resource('specialities', SpecialitiesController::class);

//hospital
Route::resource('hospital', HospitalController::class);

//HospitalStaff
Route::resource('hospitalstaff', HospitalStaffController::class);

//doctor
Route::resource('doctor', DoctorController::class);

//Pharmacist
Route::resource('pharmacist', PharmacistController::class);

//Laboratorist
Route::resource('laboratorist', LaboratoristController::class);

//Customer
Route::resource('customer', CustomerController::class);

//Pharmacy
Route::resource('pharmacy', PharmacyController::class);

//Product
Route::resource('product', ProductController::class);

//Category
Route::resource('category', CategoryController::class);
Route::resource('categoryEqp', CategoryEqpController::class);
Route::resource('service_payment', ServicePaymentController::class); 

//SubCategory
Route::resource('subcategory', SubCategoryController::class);

Route::get('product/subcategory/ajax/{id}', [ProductController::class, 'subCategoryAjax'])->name('product.subcategory.ajax');

//Lab Category
Route::resource('labtestcategory', LabtestcategoryController::class);

//Lab test
Route::resource('labtest', LabtestController::class);
Route::resource('labtestpackage', LabtestpackageController::class);

Route::get('labtestpackage/labtest/ajax/{id}', [LabtestpackageController::class, 'labTestAjax'])->name('product.labtest.ajax');


Route::get('bloodbank/component', [BloodbankController::class, 'component'])->name('bloodbank.component');

Route::get('bloodbank/{id}/componentEdit', [BloodbankController::class, 'componentEdit'])->name('bloodbank.editcomponent');
Route::post('bloodbank/storeComponent', [BloodbankController::class, 'storeComponent'])->name('bloodbank.storeComponent'); 
Route::put('bloodbank/updateComponent/{id}', [BloodbankController::class, 'updateComponent'])->name('bloodbank.updateComponent');
Route::resource('bloodbank', BloodbankController::class);
Route::resource('bloodbankstock', BloodbankstockController::class);


Route::resource('nursing', NursingController::class);

Route::resource('ambulance', AmbulanceController::class);
Route::resource('dealer', DealerController::class);
Route::resource('ambulanceType', AmbulanceTypeController::class);
Route::resource('composition', CompositionController::class);
