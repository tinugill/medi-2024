import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './controller/home/home.component';

import { LoginComponent } from './controller/login/login.component';
import { SignupComponent } from './controller/signup/signup.component';
import { DoctorIndexComponent } from './controller/doctor/doctor-index/doctor-index.component';
import { DoctorListComponent } from './controller/doctor/doctor-list/doctor-list.component';
import { DoctorProfileComponent } from './controller/doctor/doctor-profile/doctor-profile.component';
import { VideoConsultComponent } from './controller/doctor/video-consult/video-consult.component';

import { PharmacyComponent } from './controller/Pharmacy/pharmacy/pharmacy.component';
import { CategoryComponent } from './controller/Pharmacy/category/category.component';
import { ProductDetailsComponent } from './controller/Pharmacy/product-details/product-details.component';
import { CartListComponent } from './controller/Pharmacy/cart-list/cart-list.component';

import { LabIndexComponent } from './controller/Lab/lab-index/lab-index.component';
import { LabListComponent } from './controller/Lab/lab-list/lab-list.component';
import { LabDetailsComponent } from './controller/Lab/lab-details/lab-details.component';
import { TestDetailsComponent } from './controller/Lab/test-details/test-details.component';

import { BloodBankIndexComponent } from './controller/blood-bank/blood-bank-index/blood-bank-index.component';
import { BloodBankListComponent } from './controller/blood-bank/blood-bank-list/blood-bank-list.component';
import { BloodBankDetailsComponent } from './controller/blood-bank/blood-bank-details/blood-bank-details.component';

import { HospitalIndexComponent } from './controller/hospital/hospital-index/hospital-index.component';
import { HospitalListComponent } from './controller/hospital/hospital-list/hospital-list.component';
import { HospitalDetailsComponent } from './controller/hospital/hospital-details/hospital-details.component';
import { AmbulanceComponent } from './controller/Ambulance/ambulance/ambulance.component';

import { RecordComponent } from './Patient-Record/record/record.component';
import { AppointmentFormComponent } from './controller/appointment-form/appointment-form.component';

import { AddressComponent } from './controller/Pharmacy/address/address.component';
import { HomeNursingComponent } from './controller/home-nursing/home-nursing.component';
import { SurgeriesComponent } from './controller/surgeries/surgeries.component';
import { MedicalEquipmentComponent } from './controller/Equipment/medical-equipment/medical-equipment.component';

import { AboutUsComponent } from './controller/about-us/about-us.component';
import { BlogPageComponent } from './controller/blog-page/blog-page.component';
import { BlogDetailsComponent } from './controller/blog-details/blog-details.component';
import { DashboardDoctorComponent } from './dashboard/dashboard-doctor/dashboard-doctor.component';
import { DashboardHospitalComponent } from './dashboard/dashboard-hospital/dashboard-hospital.component';
import { DashboardHospitalstaffComponent } from './dashboard/dashboard-hospitalstaff/dashboard-hospitalstaff.component';
import { DashboardPharmacyComponent } from './dashboard/dashboard-pharmacy/dashboard-pharmacy.component';
import { DashboardLabComponent } from './dashboard/dashboard-lab/dashboard-lab.component';
import { DashboardBloodbankComponent } from './dashboard/dashboard-bloodbank/dashboard-bloodbank.component';
import { UserChatComponent } from './dashboard/pages/user-chat/user-chat.component';
import { VideoZoomComponent } from './dashboard/pages/video-zoom/video-zoom.component';
import { DashboardNursingComponent } from './dashboard/dashboard-nursing/dashboard-nursing.component';
import { DashboardDealerComponent } from './dashboard/dashboard-dealer/dashboard-dealer.component';
import { DashboardAmbulanceComponent } from './dashboard/dashboard-ambulance/dashboard-ambulance.component';
import { EquipmentListComponent } from './controller/Equipment/equipment-list/equipment-list.component';
import { EquipmentInfoComponent } from './controller/Equipment/equipment-info/equipment-info.component';
import { NursingListComponent } from './controller/nursing/nursing-list/nursing-list.component';
import { NursingInfoComponent } from './controller/nursing/nursing-info/nursing-info.component';
import { TermsComponent } from './controller/terms/terms.component';
import { AmbulanceListComponent } from './controller/Ambulance/ambulance-list/ambulance-list.component';
import { AmbulanceInfoComponent } from './controller/Ambulance/ambulance-info/ambulance-info.component';
import { PrivacyPolicyComponent } from './controller/privacy-policy/privacy-policy.component';
import { RefundComponent } from './common/refund/refund.component';
import { ReviewPageComponent } from './controller/review-page/review-page.component';
import { ContactUsComponent } from './controller/contact-us/contact-us.component';

import { DrProfileShareComponent } from './controller/dr-profile-share/dr-profile-share.component';

const routes: Routes = [
  { path: '', redirectTo: '/home', pathMatch: 'full' },
  {
    path: 'home',
    component: HomeComponent,
    data: {
      title: 'Home',
      description: 'Description Meta Tag Content',
    },
    pathMatch: 'full',
  },

  { path: 'Tnc', component: TermsComponent, pathMatch: 'full' },
  { path: 'privacy-policy', component: PrivacyPolicyComponent, pathMatch: 'full' },
  { path: 'refund', component: RefundComponent, pathMatch: 'full' },
  { path: 'login', component: LoginComponent, pathMatch: 'full' },
  { path: 'signup', component: SignupComponent, pathMatch: 'full' },
  {
    path: 'chat',
    component: UserChatComponent,
    pathMatch: 'full',
  },
  {
    path: 'review-of/:type/:id',
    component: ReviewPageComponent,
    pathMatch: 'full',
  },
  {
    path: 'meeting/:msg/:appointment_id/:msgId',
    loadChildren: () =>
      import("./dashboard/pages/v-zoom/v-zoom.module").then(
        (m) => m.VZoomModule
      ),
    pathMatch: 'full',
  },
 
  {
    path: 'doctor',
    component: DoctorIndexComponent,
    pathMatch: 'full',
  },
  {
    path: 'doctor-list',
    component: DoctorListComponent,
    pathMatch: 'full',
  },
  {
    path: 'doctor/:slug',
    component: DoctorProfileComponent,
    pathMatch: 'full',
  },
  {
    path: 'video-consult',
    component: VideoConsultComponent,
    pathMatch: 'full',
  },
  {
    path: 'pharmacy',
    component: PharmacyComponent,
    pathMatch: 'full',
  },
  {
    path: 'medicine-list',
    component: CategoryComponent,
    pathMatch: 'full',
  },
  {
    path: 'pharmacy/:category',
    component: CategoryComponent,
    pathMatch: 'full',
  },
  {
    path: 'pharmacy/p/:slug',
    component: ProductDetailsComponent,
    pathMatch: 'full',
  },
  {
    path: 'cart',
    component: CartListComponent,
    pathMatch: 'full',
  },
  { path: 'pharmacy/address', component: AddressComponent, pathMatch: 'full' },

  { path: 'lab', component: LabIndexComponent, pathMatch: 'full' },
  { path: 'lab/lab-list', component: LabListComponent, pathMatch: 'full' },
  {
    path: 'lab/:slug',
    component: LabDetailsComponent,
    pathMatch: 'full',
  },
  {
    path: 'lab/test-details',
    component: TestDetailsComponent,
    pathMatch: 'full',
  },

  {
    path: 'blood-bank',
    component: BloodBankIndexComponent,
    pathMatch: 'full',
  },
  {
    path: 'blood-bank/blood-bank-list',
    component: BloodBankListComponent,
    pathMatch: 'full',
  },
  {
    path: 'blood-bank-details/:slug',
    component: BloodBankDetailsComponent,
    pathMatch: 'full',
  },
  {
    path: 'hospital',
    component: HospitalIndexComponent,
    pathMatch: 'full',
  },
  {
    path: 'hospital/:slug',
    component: HospitalDetailsComponent,
    pathMatch: 'full',
  },
  {
    path: 'hospital-list',
    component: HospitalListComponent,
    pathMatch: 'full',
  },
  {
    path: 'ambulance',
    component: AmbulanceComponent,
    pathMatch: 'full',
  },
  {
    path: 'ambulance/list',
    component: AmbulanceListComponent,
    pathMatch: 'full',
  },
  {
    path: 'ambulance-details/:slug',
    component: AmbulanceInfoComponent,
    pathMatch: 'full',
  },

  {
    path: 'Patient-Record/record',
    component: RecordComponent,
    pathMatch: 'full',
  },
  {
    path: 'appointment-form/:slug',
    component: AppointmentFormComponent,
    pathMatch: 'full',
  },
  {
    path: 'dashboard/pharmacy',
    component: DashboardPharmacyComponent,
    pathMatch: 'full',
  },
  {
    path: 'dashboard/doctor',
    component: DashboardDoctorComponent,
    pathMatch: 'full',
  },
  {
    path: 'dashboard/hospital',
    component: DashboardHospitalComponent,
    pathMatch: 'full',
  }, 
  {
    path: 'dashboard/dealer',
    component: DashboardDealerComponent,
    pathMatch: 'full',
  },
    {
      path: 'dashboard/ambulance',
      component: DashboardAmbulanceComponent,
      pathMatch: 'full',
    },
  {
    path: 'dashboard/lab',
    component: DashboardLabComponent,
    pathMatch: 'full',
  },
  {
    path: 'dashboard/bloodbank',
    component: DashboardBloodbankComponent,
    pathMatch: 'full',
  },
  {
    path: 'dashboard/Nursing',
    component: DashboardNursingComponent,
    pathMatch: 'full',
  },
  {
    path: 'dashboard/staff',
    component: DashboardHospitalstaffComponent,
    pathMatch: 'full',
  },
 
  { path: 'surgeri', component: SurgeriesComponent },
  { path: 'equipment/medical-equipment', component: MedicalEquipmentComponent },
  
  {
    path: 'equipment/equipment-list',
    component: EquipmentListComponent,
    pathMatch: 'full',
  },
  {
    path: 'equipment/i/:id',
    component: EquipmentInfoComponent,
    pathMatch: 'full',
  },
  { path: 'home-nursing', component: HomeNursingComponent }, 
  {
    path: 'home-nursing/list',
    component: NursingListComponent,
    pathMatch: 'full',
  },
  {
    path: 'home-nursing/i/:id',
    component: NursingInfoComponent,
    pathMatch: 'full',
  },
  { path: 'about-us', component: AboutUsComponent },
  { path: 'blog', component: BlogPageComponent },
  { path: 'blog/:slug', component: BlogDetailsComponent },
  { path: 'contact', component: ContactUsComponent },
  { path: 'dr-profile-share', component: DrProfileShareComponent}
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { scrollPositionRestoration: 'enabled' }),
  ],
  exports: [RouterModule],
})
export class AppRoutingModule {}
