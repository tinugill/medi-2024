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
                <div>Bloodbank
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Bloodbank</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('bloodbank.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('bloodbank.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->name}}@endif" name="name" placeholder="Enter Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Owner Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->owner_name}}@endif" name="owner_name" placeholder="Enter Owner Name" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Communication Number (Public)</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->public_number}}@endif" name="public_number" placeholder="Enter Number" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <!-- <div class="col-md-4 mb-3">
                            <label>Hospital Name</label>
                            <select name="hospital_id" class="form-control" id="hospital_id">
                                <option selected value="0">Please Select One</option>
                                @foreach($hospital as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $bloodbank->hospital_id  ? 'selected' : ''}}@endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div> -->
                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->email}}@endif" name="email" placeholder="Enter Email" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Mobile</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->mobile}}@endif" name="mobile" placeholder="Enter Mobile" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>About</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->about}}@endif" name="about" placeholder="About">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->address}}@endif" name="address" placeholder="Enter Address" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>City</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->city}}@endif" name="city" placeholder="Enter City" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Pincode</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->pincode}}@endif" name="pincode" placeholder="Enter Pincode" minlength="6" maxlength="6"  number>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Country</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->country}}@endif" name="country" placeholder="Enter Country" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Latitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->latitude}}@endif" name="latitude" placeholder="Enter Latitude">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Longitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->longitude}}@endif" name="longitude" placeholder="Enter Longitude">
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
                            <label>Liscence number</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->liscence_no}}@endif" name="liscence_no">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Owner/Contact Person</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->cp_name}}@endif" name="cp_name">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Liscence certificate file @if($id)
                                <a href="{{asset('hospital_image/'.$bloodbank->liscence_file)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" name="liscence_file">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Working days</label>
                            <select class="form-control" name="days[]" multiple>
                                <?php $days = json_decode(@$bloodbank->days, true);
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
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbank)->slug}}@endif" name="slug" placeholder="Enter slug">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Image</label>
                            @if($id)
                            <a href="{{asset('hospital_image/'.$bloodbank->image)}}" target="_blank">View Image</a>
                            @endif

                            <input type="file" class="form-control" name="image" placeholder="Enter Image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Banner Image</label>
                            @if($id)
                            <a href="{{asset('hospital_image/'.$bloodbank->banner_image)}}" target="_blank">View Image</a>
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