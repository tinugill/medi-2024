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
                <div>Ambulance Provider
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Info</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('ambulance.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('ambulance.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label>Registered Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->name}}@endif" name="name" placeholder="Enter Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Owner Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->owner_name}}@endif" name="owner_name" placeholder="Enter Owner Name">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Public number</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->public_number}}@endif" name="public_number" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                          
                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->email}}@endif" name="email" placeholder="Enter Email" required >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Mobile</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->mobile}}@endif" name="mobile" placeholder="Enter Mobile" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>User Type</label>
                            <select class="form-control" name="type_of_user">
                                <option value="Firm" <?php if ($id != '' && $ambulance->type_of_user == 'Firm') { echo 'selected'; } ?>>Firm</option>
                                <option value="Individual" <?php if ($id != '' && $ambulance->type_of_user == 'Individual') { echo 'selected'; } ?>>Individual</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                      
                        <div class="col-md-4 mb-3">
                            <label>About</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->about}}@endif" name="about" placeholder="About" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->address}}@endif" name="address" placeholder="Enter Address" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>City</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->city}}@endif" name="city" placeholder="Enter City" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Pincode</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->pincode}}@endif" name="pincode" placeholder="Enter Pincode" minlength="6" maxlength="6"  number>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Country</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->country}}@endif" name="country" placeholder="Enter Country" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Latitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->latitude}}@endif" name="latitude" placeholder="Enter Latitude" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Longitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->longitude}}@endif" name="longitude" placeholder="Enter Longitude" >
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
                            <label>GSTIN Number</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->gstin}}@endif" name="gstin" placeholder="About" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                         
                        <div class="col-md-4 mb-3">
                            <label>UPLOAD GSTIN PROOF @if($id)
                                <a href="{{asset('uploads/'.$ambulance->gstin_proof)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" name="gstin_proof">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>UPLOAD REGISTRATION CERTIFICATE @if($id)
                                <a href="{{asset('uploads/'.$ambulance->registration_certificate)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" name="registration_certificate">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>UPLOAD ID PROOF (AADHAR) @if($id)
                                <a href="{{asset('uploads/'.$ambulance->aadhar)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" name="aadhar">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                         
 

                        <div class="col-md-4 mb-3">
                            <label>Slug</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($ambulance)->slug}}@endif" name="slug" placeholder="Enter slug">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Image</label>
                            @if($id)
                            <a href="{{asset('uploads/'.$ambulance->image)}}" target="_blank">View Image</a>
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