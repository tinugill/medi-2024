@extends('superadmin.layouts.master_after_login')
@section('content')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="lnr-picture text-danger">
                    </i>
                </div>
                <div>
                    Doctor
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Doctor</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('doctor.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('doctor.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label>Full Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->full_name}}@endif" name="full_name" placeholder="Enter Full Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Designation</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->designation}}@endif" name="designation" placeholder="Enter designation">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->email}}@endif" name="email" placeholder="Enter Email" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Mobile</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->mobile}}@endif" name="mobile" placeholder="Enter Mobile" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Password @if($id){{ '(Enter if want to change)' }}@endif</label>
                            <input type="text" class="form-control" value="" name="password" placeholder="Enter password" @if(!$id){{ 'required' }}@endif>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Type</label>
                            <select name="type" class="form-control" id="type" required>
                                <option selected disabled>Please Select One</option>
                                <option value="Doctor" @if($id){{Optional($doctor)->type == 'Doctor'  ? 'selected' : ''}}@endif>Doctor</option>
                                <!--option value="Nurse" @if($id){{Optional($doctor)->type == 'Nurse'  ? 'selected' : ''}}@endif>Nurse</option-->
                                <option value="Staff" @if($id){{Optional($doctor)->type == 'Staff'  ? 'selected' : ''}}@endif>Staff</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Gender</label>
                            <select name="gender" class="form-control" id="gender" required>
                                <option selected disabled>Please Select One</option>
                                <option value="Male" @if($id){{Optional($doctor)->gender == 'Male'  ? 'selected' : ''}}@endif>Male</option>
                                <option value="Female" @if($id){{Optional($doctor)->gender == 'Female'  ? 'selected' : ''}}@endif>Female</option>
                                <option value="Other" @if($id){{Optional($doctor)->gender == 'Other'  ? 'selected' : ''}}@endif>Other</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <?php if ($id) {
                            $Specialization = json_decode($doctor->specialization_id, true);
                            if ($Specialization == '') {
                                $Specialization = array();
                            }
                        } else {
                            $Specialization = array();
                        } ?>
                        <div class="col-md-4 mb-3">
                            <label>Qualification</label>
                            <select name="specialization_id[]" class="form-control" id="specialization_id" multiple="multiple" >
                                @foreach($specialization as $row)
                                <option value="{{$row->id}}" @if($id){{in_array($row->id, $Specialization)  ? 'selected' : ''}}@endif>{{$row->degree}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <?php if ($id) {
                            $Speciality = json_decode($doctor->specialities_id, true);
                            if ($Speciality == '') {
                                $Speciality = array();
                            }
                        } else {
                            $Speciality = array();
                        } ?>
                        <div class="col-md-4 mb-3">
                            <label>Speciality</label>
                            <select name="specialities_id[]" class="form-control" id="specialities_id" multiple="multiple" >
                                @foreach($specialities as $row)
                                <option value="{{$row->id}}" @if($id){{in_array($row->id, $Speciality)  ? 'selected' : ''}}@endif>{{$row->speciality_name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <?php if ($id) {
                            $Workingday = json_decode($doctor->working_days, true);
                            if ($Workingday == '') {
                                $Workingday = array();
                            }
                        } else {
                            $Workingday = array();
                        } ?>
                        <div class="col-md-4 mb-3">
                            <label>Working Days</label>
                            <select name="working_days[]" class="form-control" id="working_days" multiple>

                                <option value="Sunday" @if($id){{in_array('Sunday', $Workingday)  ? 'selected' : ''}}@endif>Sunday</option>
                                <option value="Monday" @if($id){{in_array('Monday', $Workingday)  ? 'selected' : ''}}@endif>Monday</option>
                                <option value="Tuesday" @if($id){{in_array('Tuesday', $Workingday)  ? 'selected' : ''}}@endif>Tuesday</option>
                                <option value="Wednesday" @if($id){{in_array('Wednesday', $Workingday)  ? 'selected' : ''}}@endif>Wednesday</option>
                                <option value="Thursday" @if($id){{in_array('Thursday', $Workingday)  ? 'selected' : ''}}@endif>Thursday</option>
                                <option value="Friday" @if($id){{in_array('Friday', $Workingday)  ? 'selected' : ''}}@endif>Friday</option>
                                <option value="Saturday" @if($id){{in_array('Saturday', $Workingday)  ? 'selected' : ''}}@endif>Saturday</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Degree File</label>
                            @if($id)
                            <a href="{{asset('doctor_image/'.$doctor->degree_file  )}}" target="_blank">View File</a>
                            @endif
                            <input type="file" class="form-control" name="degree_file" placeholder="Enter Degree File">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>


                        <div class="col-md-4 mb-3">

                            <label>Doctor Image</label>
                            @if($id)
                            <a href="{{asset('doctor_image/'.$doctor->doctor_image)}}" target="_blank">View Image</a>
                            @endif
                            <input type="file" class="form-control" name="doctor_image" placeholder="Enter Doctor Image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Doctor Banner</label>

                            @if($id)
                            <a href="{{asset('doctor_image/'.$doctor->doctor_banner)}}" target="_blank">View Banner</a>
                            @endif
                            <input type="file" class="form-control" name="doctor_banner" placeholder="Enter Doctor Banner">

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Letterhead File</label>
                            @if($id)
                            <a href="{{asset('doctor_image/'.$doctor->letterhead  )}}" target="_blank">View File</a>
                            @endif
                            <input type="file" class="form-control" name="letterhead" placeholder="Enter Letterhead File">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Signature File</label>
                            @if($id)
                            <a href="{{asset('doctor_image/'.$doctor->signature  )}}" target="_blank">View File</a>
                            @endif
                            <input type="file" class="form-control" name="signature" placeholder="Enter Signature File">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label>Home Visit</label>
                            <select class="form-control" value="" name="home_visit" placeholder="Enter Home Visit">
                                <option value="Yes" @if($id){{$doctor->home_visit == 'Yes' ? 'selected' : ''}}@endif>Yes</option>
                                <option value="No" @if($id){{$doctor->home_visit == 'No' ? 'selected' : ''}}@endif>Yes</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Consultancy Fee</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->consultancy_fee}}@endif" name="consultancy_fee" placeholder="Enter Consultancy Fee">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Home Consultancy Fee</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->home_consultancy_fee}}@endif" name="home_consultancy_fee" placeholder="Enter Home Consultancy Fee">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Online Consultancy Fee</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->online_consultancy_fee}}@endif" name="online_consultancy_fee" placeholder="Enter Online Consultancy Fee">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>About</label>
                            <textarea class="form-control" name="about" placeholder="Enter About">@if($id){{Optional($doctor)->about}}@endif</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Awards</label>
                            <textarea class="form-control" name="award" placeholder="Enter Award">@if($id){{Optional($doctor)->award}}@endif</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Experience</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($doctor)->experience}}@endif" name="experience" placeholder="Enter Experience">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Memberships Detail</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->memberships_detail}}@endif" name="memberships_detail" placeholder="Enter Memberships Detail">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Registration Details</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->registration_details}}@endif" name="registration_details" placeholder="Enter Registration Details">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Medical Counselling</label>
                            <select name="medical_counsiling" class="form-control" id="medical_counsiling">
                                <option selected disabled>Please Select One</option>
                                @foreach($medical_counsiling as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $doctor->medical_counsiling  ? 'selected' : ''}}@endif>{{$row->title}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Registration certificate</label>

                            @if($id)
                            <a href="{{asset('doctor_image/'.$doctor->registration_certificate)}}" target="_blank">View File</a>
                            @endif
                            <input type="file" class="form-control" name="registration_certificate" placeholder="Enter Registration certificate">

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Latitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->latitude}}@endif" name="latitude" placeholder="Enter Latitude">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Longitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->longitude}}@endif" name="longitude" placeholder="Enter Longitude">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Hospital</label>
                            <select name="hospital_id" class="form-control" id="hospital_id">
                                <option selected disabled>Please Select One</option>
                                @foreach($hospital as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $doctor->hospital_id  ? 'selected' : ''}}@endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->address}}@endif" name="address" placeholder="Enter Address">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>City</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->city}}@endif" name="city" placeholder="Enter City">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Pincode</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->pincode}}@endif" name="pincode" placeholder="Enter Pincode">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Country</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->country}}@endif" name="country" placeholder="Enter Country">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Slug</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($doctor)->slug}}@endif" name="slug" placeholder="Enter Slug">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Full Name on Bank account</label>
                            <input type="text" class="form-control" name="name_on_bank" value="@if($id){{Optional($Doctor_bank_docs)->name}}@endif">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Bank Name</label>
                            <input type="text" class="form-control" name="bank_name" value="@if($id){{Optional($Doctor_bank_docs)->bank_name}}@endif">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Branch Name</label>
                            <input type="text" class="form-control" name="branch_name" value="@if($id){{Optional($Doctor_bank_docs)->branch_name}}@endif">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>IFSC Code</label>
                            <input type="text" class="form-control" name="ifsc" value="@if($id){{Optional($Doctor_bank_docs)->ifsc}}@endif">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Account Number</label>
                            <input type="text" class="form-control" name="ac_no" value="@if($id){{Optional($Doctor_bank_docs)->ac_no}}@endif">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Account Type</label>
                            <select class="form-control" name="ac_type">
                                <option value="saving" <?php if (isset($id) && isset($Doctor_bank_docs->ac_type) && $Doctor_bank_docs->ac_type == 'saving') {
                                                            echo 'selected';
                                                        } ?>>Saving</option>
                                <option value="current" <?php if (isset($id) && isset($Doctor_bank_docs->ac_type) && $Doctor_bank_docs->ac_type == 'current') {
                                                            echo 'selected';
                                                        } ?>>Current</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>MICR Code</label>
                            <input type="text" class="form-control" name="micr_code" value="@if($id){{Optional($Doctor_bank_docs)->micr_code}}@endif">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Cancel Cheque</label>
                            @if($id)
                            <a href="{{asset('doctor_image/'.Optional($Doctor_bank_docs)->cancel_cheque  )}}" target="_blank">View File</a>
                            @endif
                            <input type="file" class="form-control" name="cancel_cheque" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>PAN Number</label>
                            <input type="text" class="form-control" name="pan_no" value="@if($id){{Optional($Doctor_bank_docs)->pan_no}}@endif">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>PAN Image</label>
                            @if($id)
                            <a href="{{asset('doctor_image/'.Optional($Doctor_bank_docs)->pan_image  )}}" target="_blank">View File</a>
                            @endif
                            <input type="file" class="form-control" name="pan_image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>


                    </div>


                    <button class="btn btn-primary" type="submit">Submit form</button>
                </form>

                <script>
                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                    (function() {
                        'use strict';
                        window.addEventListener('load', function() {
                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            var forms = document.getElementsByClassName('needs-validation');
                            // Loop over them and prevent submission
                            var validation = Array.prototype.filter.call(forms, function(form) {
                                form.addEventListener('submit', function(event) {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        }, false);
                    })();

                    // $(function() {
                    //     $( "#appointment_timing" ).datepicker({
                    //         defaultDate:"09/22/2019"
                    //     });
                    // });
                </script>
        </div>
    </div>
    @endsection