<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <a href="index.html" class="mm-active">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Dashboard Example 1
                    </a>
                </li>
                <li class="app-sidebar__heading">Manage Components</li>
                <?php $segment = Request::segment(1); ?>
                <li class="@if($segment == 'service_payment'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Listing Charges
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'service_payment'){{'mm-show'}}@endif"> 
                        <li>
                            <a href="{{route('service_payment.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'listing_discount_list'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Listing Discount
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'listing_discount_list'){{'mm-show'}}@endif"> 
                    <li>
                            <a href="{{route('listing_discount_list.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('listing_discount_list.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'designation'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Designation
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'designation'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('designation.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('designation.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'composition'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Composition
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'composition'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('composition.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('composition.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'ambulanceType'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Ambulance Type
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'ambulanceType'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('ambulanceType.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('ambulanceType.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'medical_counsling'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Medical Counselling
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'medical_counsling'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('medical_counsling.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('medical_counsling.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'labtest_masterdb'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Labtest
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'labtest_masterdb'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('labtest_masterdb.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('labtest_masterdb.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'illness_list'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Illness / Diseases
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'illness_list'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('illness_list.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('illness_list.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'symptom_list'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Symptoms
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'symptom_list'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('symptom_list.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('symptom_list.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'treatment_list'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Treatments & Surgery
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'treatment_list'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('treatment_list.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('treatment_list.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'specialization'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Qualification
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'specialization'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('specialization.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('specialization.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'specialities'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Specialities
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'specialities'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('specialities.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('specialities.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'procedures'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-car"></i>
                        Procedures
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'procedures'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('procedures.create')}}">
                                <i class="metismenu-icon">
                                </i>Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('procedures.index')}}">
                                <i class="metismenu-icon">
                                </i>View
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="@if($segment == 'dignosis_list'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Diagnosis
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'dignosis_list'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('dignosis_list.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('dignosis_list.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'empanelments_list'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Empanelments
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'empanelments_list'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('empanelments_list.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('empanelments_list.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'facility_list'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Facilities
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'facility_list'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('facility_list.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('facility_list.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="@if($segment == 'hospital'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Hospital
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'hospital'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('hospital.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('hospital.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- <li class="@if($segment == 'hospitalstaff'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Hospital Staff
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'hospitalstaff'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('hospitalstaff.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('hospitalstaff.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li> -->

                <li class="@if($segment == 'doctor'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Doctor
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'doctor'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('doctor.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('doctor.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- <li class="@if($segment == 'pharmacist'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Pharmacist
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'pharmacist'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('pharmacist.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('pharmacist.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li> -->
                <li class="@if($segment == 'laboratorist'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Laboratorist
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'laboratorist'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('laboratorist.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('laboratorist.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="@if($segment == 'labtestcategory'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Lab Test Categories
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'labtestcategory'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('labtestcategory.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('labtestcategory.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="@if($segment == 'labtest'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Lab Test
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'labtest'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('labtest.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('labtest.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="@if($segment == 'labtestpackage'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Lab Test Packages
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'labtestpackage'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('labtestpackage.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('labtestpackage.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="@if($segment == 'customer'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Customers
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'customer'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('customer.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('customer.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>


                    </ul>
                </li>
                <li class="@if($segment == 'nursing'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Nursing
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'nursing'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('nursing.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('nursing.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="@if($segment == 'pharmacy'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Pharmacy
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'pharmacy'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('pharmacy.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('pharmacy.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="@if($segment == 'ambulance'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Ambulance
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'ambulance'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('ambulance.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('ambulance.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="@if($segment == 'dealer'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Dealers
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'dealer'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('dealer.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('dealer.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="@if($segment == 'bloodbank'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Bloodbank
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'bloodbank'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('bloodbank.editcomponent',0)}}">
                                <i class="metismenu-icon"></i>
                                Add Component
                            </a>
                        </li>
                        <li>
                            <a href="{{route('bloodbank.component')}}">
                                <i class="metismenu-icon"></i>
                                List Component
                            </a>
                        </li>
                        <li>
                            <a href="{{route('bloodbank.create')}}">
                                <i class="metismenu-icon"></i>
                                Add Bloodbank
                            </a>
                        </li>
                        <li>
                            <a href="{{route('bloodbank.index')}}">
                                <i class="metismenu-icon">
                                </i>List Bloodbank
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="app-sidebar__heading">Products</li>
                <li class="@if($segment == 'categoryEqp'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Equipment Categories
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'categoryEqp'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('categoryEqp.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('categoryEqp.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="@if($segment == 'category'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Medicines Categories
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'category'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('category.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('category.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="@if($segment == 'subcategory'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Sub-Categories
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'subcategory'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('subcategory.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('subcategory.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li class="@if($segment == 'product'){{'mm-active'}}@endif">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Product
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="@if($segment == 'product'){{'mm-show'}}@endif">
                        <li>
                            <a href="{{route('product.create')}}">
                                <i class="metismenu-icon"></i>
                                Add
                            </a>
                        </li>
                        <li>
                            <a href="{{route('product.index')}}">
                                <i class="metismenu-icon">
                                </i>List
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="app-sidebar__heading">Forms</li>
                <li>
                    <a href="forms-controls.html">
                        <i class="metismenu-icon pe-7s-mouse">
                        </i>Forms Controls
                    </a>
                </li>
                <li>
                    <a href="forms-layouts.html">
                        <i class="metismenu-icon pe-7s-eyedropper">
                        </i>Forms Layouts
                    </a>
                </li>
                <li>
                    <a href="forms-validation.html">
                        <i class="metismenu-icon pe-7s-pendrive">
                        </i>Forms Validation
                    </a>
                </li>
                <li class="app-sidebar__heading">Charts</li>
                <li>
                    <a href="charts-chartjs.html">
                        <i class="metismenu-icon pe-7s-graph2">
                        </i>ChartJS
                    </a>
                </li>
                <li class="app-sidebar__heading">PRO Version</li>
                <li>
                    <a href="https://dashboardpack.com/theme-details/architectui-dashboard-html-pro/" target="_blank">
                        <i class="metismenu-icon pe-7s-graph2">
                        </i>
                        Upgrade to PRO
                    </a>
                </li> -->
            </ul>
        </div>
    </div>
</div>
<style>
    .max-img {
        max-width: 45px;
    }
</style>