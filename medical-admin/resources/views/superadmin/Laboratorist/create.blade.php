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
                <div>Laboratorists
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Laboratorists</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('laboratorist.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('laboratorist.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->name}}@endif" name="name" placeholder="Enter Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Owner Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->owner_name}}@endif" name="owner_name" placeholder="Enter Owner Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Owner Id Proof @if($id)
                                <a href="{{asset('laboratorist_image/'.$laboratorist->owner_id)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" name="owner_id">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Sample Collection Fee</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->h_c_fee}}@endif" name="h_c_fee" placeholder="Enter Amount" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Sample Collection Apply when amount <= </label>
                                    <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->h_c_fee_apply_before}}@endif" name="h_c_fee_apply_before" placeholder="Enter Amount" >
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Report Home Delivery Fee</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->r_d_fee}}@endif" name="r_d_fee" placeholder="Enter Amount" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Delivery fee Apply when amount <= </label>
                                    <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->r_d_fee_apply_before}}@endif" name="r_d_fee_apply_before" placeholder="Enter Amount" >
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Ambulance Fee </label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->ambulance_fee}}@endif" name="ambulance_fee" placeholder="Enter Amount" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Communication Number (for public)</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->phone_no}}@endif" name="phone_no" placeholder="Enter Number" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <!-- <div class="col-md-4 mb-3">
                            <label>Hospital Name</label>
                            <select name="hospital_id" class="form-control" id="hospital_id">
                                <option selected value="0">Please Select One</option>
                                @foreach($hospital as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $laboratorist->hospital_id  ? 'selected' : ''}}@endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div> -->
                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->email}}@endif" name="email" placeholder="Enter Email" required >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Mobile</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->mobile}}@endif" name="mobile" placeholder="Enter Mobile" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>About</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->about}}@endif" name="about" placeholder="About" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->address}}@endif" name="address" placeholder="Enter Address" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>City</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->city}}@endif" name="city" placeholder="Enter City" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Pincode</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->pincode}}@endif" name="pincode" placeholder="Enter Pincode" minlength="6" maxlength="6"  number>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Country</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->country}}@endif" name="country" placeholder="Enter Country" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Latitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->latitude}}@endif" name="latitude" placeholder="Enter Latitude" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Longitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->longitude}}@endif" name="longitude" placeholder="Enter Longitude" >
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
                            <label>Registration detail</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->registration_detail}}@endif" name="registration_detail">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Owner/Contact Person</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->cp_name}}@endif" name="cp_name">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Registration certificate @if($id)
                                <a href="{{asset('laboratorist_image/'.$laboratorist->registration_file)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" name="registration_file">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Working days</label>
                            <select class="form-control" name="days[]" multiple>
                                <?php $days = json_decode(@$laboratorist->days, true);
                                if (!is_array($days)) {
                                    $days = [];
                                }
                                ?>
                                <option value="Monday" <?php if ($id != '' && in_array('Monday', $days)) {
                                                            echo 'selected';
                                                        } ?>>Monday</option>
                                <option value="Tuesday" <?php if ($id != '' && in_array('Tuesday', $days)) {
                                                            echo 'selected';
                                                        } ?>>Tuesday</option>
                                <option value="Wednesday" <?php if ($id != '' && in_array('Wednesday', $days)) {
                                                                echo 'selected';
                                                            } ?>>Wednesday</option>
                                <option value="Thursday" <?php if ($id != '' && in_array('Thursday', $days)) {
                                                                echo 'selected';
                                                            } ?>>Thursday</option>
                                <option value="Friday" <?php if ($id != '' && in_array('Friday', $days)) {
                                                            echo 'selected';
                                                        } ?>>Friday</option>
                                <option value="Saturday" <?php if ($id != '' && in_array('Saturday', $days)) {
                                                                echo 'selected';
                                                            } ?>>Saturday</option>
                                <option value="Sunday" <?php if ($id != '' && in_array('Sunday', $days)) {
                                                            echo 'selected';
                                                        } ?>>Sunday</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
 

                        <div class="col-md-4 mb-3">
                            <label>Slug</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($laboratorist)->slug}}@endif" name="slug" placeholder="Enter slug">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Image</label>
                            @if($id)
                            <a href="{{asset('laboratorist_image/'.$laboratorist->image)}}" target="_blank">View Image</a>
                            @endif

                            <input type="file" class="form-control" name="image" placeholder="Enter Image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Banner Image</label>
                            @if($id)
                            <a href="{{asset('laboratorist_image/'.$laboratorist->banner_image)}}" target="_blank">View Image</a>
                            @endif
                            <input type="file" class="form-control" name="banner_image" placeholder="Enter Banner Image">
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