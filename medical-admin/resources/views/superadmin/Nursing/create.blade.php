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
                <div>Nursing
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Nursing</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('nursing.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('nursing.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->name}}@endif" name="name" placeholder="Enter Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                          
                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->email}}@endif" name="email" placeholder="Enter Email" required >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Mobile</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->mobile}}@endif" name="mobile" placeholder="Enter Mobile" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Nursing Type</label>
                            <select class="form-control" name="regis_type">
                                <option value="Individual" <?php if ($id != '' && $nursing->regis_type == 'Individual') { echo 'selected'; } ?>>Individual</option>
                                <option value="Buero" <?php if ($id != '' && $nursing->regis_type == 'Buero') { echo 'selected'; } ?>>Buero</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Gender</label>
                            <select class="form-control" name="gender">
                                <option value="Male" <?php if ($id != '' && $nursing->gender == 'Male') { echo 'selected'; } ?>>Male</option>
                                <option value="Female" <?php if ($id != '' && $nursing->gender == 'Female') { echo 'selected'; } ?>>Female</option>
                                <option value="Special" <?php if ($id != '' && $nursing->gender == 'Special') { echo 'selected'; } ?>>Special</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>You are a?</label>
                            <select class="form-control" name="type">
                                <option value="Nurse" <?php if ($id != '' && $nursing->type == 'Nurse') { echo 'selected'; } ?>>Nurse</option>
                                <option value="Attendant" <?php if ($id != '' && $nursing->type == 'Attendant') { echo 'selected'; } ?>>Attendant</option> 
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Part / Full time</label>
                            <select class="form-control" name="part_fill_time">
                                <option value="Full time" <?php if ($id != '' && $nursing->part_fill_time == 'Full time') { echo 'selected'; } ?>>Full time</option>
                                <option value="Part time" <?php if ($id != '' && $nursing->part_fill_time == 'Part time') { echo 'selected'; } ?>>Part time</option> 
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Timing</label>
                            <select class="form-control" name="work_hours">
                                <?php for($i = 1; $i < 11; $i++){ ?>
                                <option value="<?php echo $i;?>" <?php if ($id != '' && $nursing->work_hours == $i) { echo 'selected'; } ?>><?php echo $i;?> Hour</option> 
                                <?php } ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Is weekly off</label>
                            <select class="form-control" name="is_weekof_replacement">
                                <option value="Yes (without replacement)" <?php if ($id != '' && $nursing->is_weekof_replacement == 'Yes (without replacement)') { echo 'selected'; } ?>>Yes (without replacement)</option>
                                <option value="Yes (with replacement)" <?php if ($id != '' && $nursing->is_weekof_replacement == 'Yes (with replacement)') { echo 'selected'; } ?>>Yes (with replacement)</option> 
                                <option value="No" <?php if ($id != '' && $nursing->is_weekof_replacement == 'No') { echo 'selected'; } ?>>No</option> 
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>About</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->about}}@endif" name="about" placeholder="About" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->address}}@endif" name="address" placeholder="Enter Address" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>City</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->city}}@endif" name="city" placeholder="Enter City" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Pincode</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->pincode}}@endif" name="pincode" placeholder="Enter Pincode" minlength="6" maxlength="6"  number>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Country</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->country}}@endif" name="country" placeholder="Enter Country" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Latitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->latitude}}@endif" name="latitude" placeholder="Enter Latitude" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Longitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->longitude}}@endif" name="longitude" placeholder="Enter Longitude" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Password @if($id){{ '(Enter you want to change)'}}@endif </label>
                            <input type="password" class="form-control" value="" name="password" placeholder="Enter Password" @if(!$id){ 'required' }}@endif>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Experience (In years)</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($nursing)->experience}}@endif" name="experience" placeholder="Enter experience" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Work condition (if any)</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($nursing)->custom_remarks}}@endif" name="custom_remarks" placeholder="example: food and tea to be provided, special room needed if booked for more then 5hr, etc" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Single visit charges for procedure (excluding procedure charges)</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($nursing)->visit_charges}}@endif" name="visit_charges" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Care Charges (per hours)</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($nursing)->per_hour_charges}}@endif" name="per_hour_charges" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Care Charges (per day)</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($nursing)->per_days_charges}}@endif" name="per_days_charges" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Care Charges (per month)</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($nursing)->per_month_charges}}@endif" name="per_month_charges" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Highest Qualification</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->qualification}}@endif" name="qualification" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                         
                        <div class="col-md-4 mb-3">
                            <label>UPLOAD QUALIFICATION PROOF @if($id)
                                <a href="{{asset('uploads/'.$nursing->degree)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" name="degree">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>UPLOAD REGISTRATION CERTIFICATE @if($id)
                                <a href="{{asset('uploads/'.$nursing->registration_certificate)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" name="registration_certificate">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>UPLOAD ID PROOF (AADHAR) @if($id)
                                <a href="{{asset('uploads/'.$nursing->id_proof)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" name="id_proof">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                         
 

                        <div class="col-md-4 mb-3">
                            <label>Slug</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($nursing)->slug}}@endif" name="slug" placeholder="Enter slug">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Image</label>
                            @if($id)
                            <a href="{{asset('uploads/'.$nursing->image)}}" target="_blank">View Image</a>
                            @endif

                            <input type="file" class="form-control" name="image" placeholder="Enter Image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                         

                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
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
                </script>
        </div>
    </div>
    @endsection