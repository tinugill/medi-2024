import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ToastNotificationsModule } from 'ngx-toast-notifications';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent,DialogOverviewExampleDialog } from './app.component';
import { SlickCarouselModule } from 'ngx-slick-carousel';
import { authInterceptorProviders } from './helper/auth.interceptor';
import { CdkStepperModule } from '@angular/cdk/stepper';
import { MatStepperModule } from '@angular/material/stepper';
import { MatIconModule } from '@angular/material/icon';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';
import { CKEditorModule } from '@ckeditor/ckeditor5-angular';
import { MatExpansionModule } from '@angular/material/expansion';
import {MatDialogModule} from '@angular/material/dialog';
import {MatAutocompleteModule} from '@angular/material/autocomplete';
import { MatChipsModule} from '@angular/material/chips'
import { NgxPrintModule } from 'ngx-print';

import { HeaderComponent } from './common/header/header.component';
import { FooterComponent } from './common/footer/footer.component';
import { HomeComponent } from './controller/home/home.component';
import { NavigationComponent } from './common/navigation/navigation.component';
import { SliderComponent } from './common/slider/slider.component';
import { DownloadAppComponent } from './common/download-app/download-app.component';
import { DoctorIndexComponent } from './controller/doctor/doctor-index/doctor-index.component';
import { DrBannerComponent } from './common/dr-banner/dr-banner.component';
import { ArticlesComponent } from './common/articles/articles.component';
import { TestimonialComponent } from './common/testimonial/testimonial.component';
import { TopFooterComponent } from './common/top-footer/top-footer.component';
import { DoctorListComponent } from './controller/doctor/doctor-list/doctor-list.component';
import { DoctorProfileComponent,ReplaceLineBreaks } from './controller/doctor/doctor-profile/doctor-profile.component';
import { VideoConsultComponent } from './controller/doctor/video-consult/video-consult.component';
import { SpecialitiesComponent } from './common/specialities/specialities.component';
import { PharmacyComponent } from './controller/Pharmacy/pharmacy/pharmacy.component';
import { CategoryComponent } from './controller/Pharmacy/category/category.component';
import { ProductDetailsComponent } from './controller/Pharmacy/product-details/product-details.component';
import { CartListComponent } from './controller/Pharmacy/cart-list/cart-list.component';
import { LabIndexComponent } from './controller/Lab/lab-index/lab-index.component';
import { LabListComponent } from './controller/Lab/lab-list/lab-list.component';
import { LabDetailsComponent } from './controller/Lab/lab-details/lab-details.component';
import { TestDetailsComponent } from './controller/Lab/test-details/test-details.component';
import { BloodBankIndexComponent } from './controller/blood-bank/blood-bank-index/blood-bank-index.component';
import { BlogComponent } from './common/blog/blog.component';
import { LoginComponent } from './controller/login/login.component';
import { BloodBankListComponent } from './controller/blood-bank/blood-bank-list/blood-bank-list.component';
import { BloodBankDetailsComponent } from './controller/blood-bank/blood-bank-details/blood-bank-details.component';
import {
  HospitalIndexComponent,
  ConcatBaseString,
} from './controller/hospital/hospital-index/hospital-index.component';
import { HospitalBannerComponent } from './common/hospital-banner/hospital-banner.component';
import { AmbulanceComponent } from './controller/Ambulance/ambulance/ambulance.component';
import { AmbulanceListComponent as AmbulanceViewListComponent } from './controller/Ambulance/ambulance-list/ambulance-list.component';
import { RecordComponent } from './Patient-Record/record/record.component';
import { MedicalRecordComponent } from './Patient-Record/medical-record/medical-record.component';
import { AppointmentComponent } from './Patient-Record/appointment/appointment.component';
import { AppointmentFormComponent } from './controller/appointment-form/appointment-form.component';
import { AddressComponent } from './controller/Pharmacy/address/address.component';

import { HomeNursingComponent } from './controller/home-nursing/home-nursing.component';
import { SurgeriesComponent } from './controller/surgeries/surgeries.component';
import { MedicalEquipmentComponent } from './controller/Equipment/medical-equipment/medical-equipment.component';
import { AboutUsComponent } from './controller/about-us/about-us.component';
import { BlogPageComponent } from './controller/blog-page/blog-page.component';
import { BlogDetailsComponent } from './controller/blog-details/blog-details.component';
import { SignupComponent } from './controller/signup/signup.component';
import { DashboardDoctorComponent, ImageToBase64Pipe } from './dashboard/dashboard-doctor/dashboard-doctor.component';
import { DashboardHospitalComponent } from './dashboard/dashboard-hospital/dashboard-hospital.component';
import { DashboardHospitalstaffComponent } from './dashboard/dashboard-hospitalstaff/dashboard-hospitalstaff.component';
import { DocAppointmentListComponent } from './dashboard/pages/doc-appointment-list/doc-appointment-list.component';
import { DocSettingComponent } from './dashboard/pages/doc-setting/doc-setting.component';
import { DocSetupProfileComponent } from './dashboard/pages/doc-setup-profile/doc-setup-profile.component';
import { HospitalDocListComponent } from './dashboard/pages/hospital-doc-list/hospital-doc-list.component';

import { NgxSpinnerModule } from 'ngx-spinner';
import { AgmCoreModule } from '@agm/core';
import { DashboardPharmacyComponent,ProductFilterPipe  } from './dashboard/dashboard-pharmacy/dashboard-pharmacy.component';
import { HospitalSetupProfileComponent } from './dashboard/pages/hospital-setup-profile/hospital-setup-profile.component';
import { DashboardLabComponent } from './dashboard/dashboard-lab/dashboard-lab.component';
import { LabSetupProfileComponent } from './dashboard/pages/lab-setup-profile/lab-setup-profile.component';
import { LabTestListComponent } from './dashboard/pages/lab-test-list/lab-test-list.component';
import { LabPackageListComponent } from './dashboard/pages/lab-package-list/lab-package-list.component';
import { BloodbankSetupProfileComponent } from './dashboard/pages/bloodbank-setup-profile/bloodbank-setup-profile.component';
import { DashboardBloodbankComponent } from './dashboard/dashboard-bloodbank/dashboard-bloodbank.component';
import { BloodbankStockListComponent } from './dashboard/pages/bloodbank-stock-list/bloodbank-stock-list.component';
import {
  DashboardBlogComponent,
  StripHtmlPipe,
} from './dashboard/dashboard-blog/dashboard-blog.component';
import { DashboardTreatmentComponent } from './dashboard/pages/dashboard-treatment/dashboard-treatment.component';
import { PharmacySetupProfileComponent } from './dashboard/pages/pharmacy-setup-profile/pharmacy-setup-profile.component';
import { BloodbankDonationComponent } from './dashboard/pages/bloodbank-donation/bloodbank-donation.component';
import { DocTreatmentRequestComponent } from './dashboard/pages/doc-treatment-request/doc-treatment-request.component';
import { LabTestRequestComponent } from './dashboard/pages/lab-test-request/lab-test-request.component';
import { UserLabtestRequestComponent } from './dashboard/pages/user-labtest-request/user-labtest-request.component';
import { UserOrdersComponent } from './dashboard/pages/user-orders/user-orders.component';
import { UserTreatmentComponent } from './dashboard/pages/user-treatment/user-treatment.component';
import { UserChatComponent } from './dashboard/pages/user-chat/user-chat.component';
// import { VideoZoomComponent } from './dashboard/pages/video-zoom/video-zoom.component';
import { DashboardNursingComponent } from './dashboard/dashboard-nursing/dashboard-nursing.component';
import { SetupNursingComponent } from './dashboard/pages/setup-nursing/setup-nursing.component';
import { DashboardDealerComponent } from './dashboard/dashboard-dealer/dashboard-dealer.component';
import { SetupDealerComponent } from './dashboard/pages/setup-dealer/setup-dealer.component';
import { DealerProductsComponent } from './dashboard/pages/dealer-products/dealer-products.component';
import { EquipmentListComponent } from './controller/Equipment/equipment-list/equipment-list.component';
import { EquipmentInfoComponent } from './controller/Equipment/equipment-info/equipment-info.component';
import { DealerProductOrdersComponent } from './dashboard/pages/dealer-product-orders/dealer-product-orders.component';
import { NursingListComponent } from './controller/nursing/nursing-list/nursing-list.component';
import { NursingInfoComponent } from './controller/nursing/nursing-info/nursing-info.component';
import { NursingCareRequestComponent } from './dashboard/pages/nursing-care-request/nursing-care-request.component';
import { NursingProcedureListComponent } from './dashboard/pages/nursing-procedure-list/nursing-procedure-list.component';
import { AddresssAddComponent } from './dashboard/pages/addresss-add/addresss-add.component';
import { DashboardAmbulanceComponent } from './dashboard/dashboard-ambulance/dashboard-ambulance.component';
import { AmbulanceSetupProfileComponent } from './dashboard/pages/ambulance-setup-profile/ambulance-setup-profile.component';
import { AmbulanceListComponent } from './dashboard/pages/ambulance-list/ambulance-list.component';
import { AmbulanceDriverListComponent } from './dashboard/pages/ambulance-driver-list/ambulance-driver-list.component';
import { HomecareNurseComponent } from './dashboard/pages/homecare-nurse/homecare-nurse.component';
import { DeliveryBoyComponent } from './dashboard/pages/delivery-boy/delivery-boy.component';
import { HospitalListComponent } from './controller/hospital/hospital-list/hospital-list.component';
import { HospitalDetailsComponent } from './controller/hospital/hospital-details/hospital-details.component';
import { TermsComponent } from './controller/terms/terms.component';
import { AmbulanceInfoComponent } from './controller/Ambulance/ambulance-info/ambulance-info.component';
import { AmbulanceBookingReqComponent } from './dashboard/pages/ambulance-booking-req/ambulance-booking-req.component';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MAT_DATE_LOCALE } from '@angular/material/core';
import {MatNativeDateModule} from '@angular/material/core';
import { ListingstatusComponent } from './common/listingstatus/listingstatus.component';
import { PrivacyPolicyComponent } from './controller/privacy-policy/privacy-policy.component';
import { RatingSectionComponent } from './common/rating-section/rating-section.component';
import { RatingInfoComponent } from './common/rating-info/rating-info.component';
import { ReviewPageComponent } from './controller/review-page/review-page.component';
import { ContactUsComponent } from './controller/contact-us/contact-us.component';
import { DrProfileShareComponent } from './controller/dr-profile-share/dr-profile-share.component';
import { RefundComponent } from './common/refund/refund.component';
@NgModule({
  declarations: [
    AppComponent,
    DialogOverviewExampleDialog,
    HeaderComponent,
    FooterComponent,
    HomeComponent,
    NavigationComponent,
    SliderComponent,
    DownloadAppComponent,
    DoctorIndexComponent,
    DrBannerComponent,
    ArticlesComponent,
    TestimonialComponent,
    TopFooterComponent,
    DoctorListComponent,
    DoctorProfileComponent,
    ReplaceLineBreaks,
    VideoConsultComponent,
    SpecialitiesComponent,
    PharmacyComponent,
    CategoryComponent,
    ProductDetailsComponent,
    CartListComponent,
    LabIndexComponent,
    LabListComponent,
    LabDetailsComponent,
    TestDetailsComponent,
    BloodBankIndexComponent,
    BlogComponent,
    LoginComponent,
    BloodBankListComponent,
    BloodBankDetailsComponent,
    HospitalIndexComponent,
    ConcatBaseString,
    HospitalBannerComponent,
    AmbulanceComponent,
    AmbulanceViewListComponent,
    RecordComponent,
    MedicalRecordComponent,
    AppointmentComponent,
    AppointmentFormComponent,
    AddressComponent,
    HomeNursingComponent,
    SurgeriesComponent,
    MedicalEquipmentComponent,
    AboutUsComponent,
    BlogDetailsComponent,
    BlogPageComponent,
    SignupComponent,
    DashboardDoctorComponent,
    ImageToBase64Pipe,
    DashboardHospitalComponent,
    DashboardHospitalstaffComponent,
    DocAppointmentListComponent,
    DocSettingComponent,
    DocSetupProfileComponent,
    HospitalDocListComponent,
    DashboardPharmacyComponent,
    ProductFilterPipe,
    HospitalSetupProfileComponent,
    DashboardLabComponent,
    LabSetupProfileComponent,
    LabTestListComponent,
    LabPackageListComponent,
    BloodbankSetupProfileComponent,
    DashboardBloodbankComponent,
    BloodbankStockListComponent,
    DashboardBlogComponent,
    StripHtmlPipe,
    DashboardTreatmentComponent,
    PharmacySetupProfileComponent,
    BloodbankDonationComponent,
    DocTreatmentRequestComponent,
    LabTestRequestComponent,
    UserLabtestRequestComponent,
    UserOrdersComponent,
    UserTreatmentComponent,
    UserChatComponent,
    // VideoZoomComponent,
    DashboardNursingComponent,
    SetupNursingComponent,
    DashboardDealerComponent,
    SetupDealerComponent,
    DealerProductsComponent,
    EquipmentListComponent,
    EquipmentInfoComponent,
    DealerProductOrdersComponent,
    NursingListComponent,
    NursingInfoComponent,
    NursingCareRequestComponent,
    NursingProcedureListComponent,
    AddresssAddComponent,
    DashboardAmbulanceComponent,
    AmbulanceSetupProfileComponent,
    AmbulanceListComponent,
    AmbulanceDriverListComponent,
    HomecareNurseComponent,
    DeliveryBoyComponent,
    HospitalListComponent,
    HospitalDetailsComponent,
    TermsComponent,
    AmbulanceInfoComponent,
    AmbulanceBookingReqComponent,
    ListingstatusComponent,
    PrivacyPolicyComponent,
    RatingSectionComponent,
    RatingInfoComponent,
    ReviewPageComponent,
    ContactUsComponent,
    DrProfileShareComponent,
    RefundComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    SlickCarouselModule,
    CdkStepperModule,
    MatStepperModule,
    MatIconModule,
    NgxPrintModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule,
    CKEditorModule,
    MatExpansionModule,
    MatDialogModule,
    MatAutocompleteModule,
    MatChipsModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    BrowserAnimationsModule,
    NgxSpinnerModule,
    MatDatepickerModule,
    MatNativeDateModule,
    ToastNotificationsModule.forRoot({
      duration: 6000,
      type: 'primary',
      position: 'top-right',
    }),
    AgmCoreModule.forRoot({ 
      apiKey: 'AIzaSyAu1H4ENLjfpmns9xAVmxXqb3awZyLpi80',
      libraries: ['places']
    })
  ],
  providers: [authInterceptorProviders, { provide: MAT_DATE_LOCALE, useValue: 'en-GB'}],
  bootstrap: [AppComponent],
})
export class AppModule {}
