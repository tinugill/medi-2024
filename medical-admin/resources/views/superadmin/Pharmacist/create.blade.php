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
                    Pharmacist
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Pharmacist</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('pharmacist.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('pharmacist.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacist)->name}}@endif" name="name" placeholder="Enter Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Hospital Name</label>
                            <select name="hospital_id" class="form-control" id="hospital_id" required>
                                <option selected disabled>Please Select One</option>
                                @foreach($hospital as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $pharmacist->hospital_id  ? 'selected' : ''}}@endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacist)->email}}@endif" name="email" placeholder="Enter Email" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Mobile</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacist)->mobile}}@endif" name="mobile" placeholder="Enter Mobile" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacist)->address}}@endif" name="address" placeholder="Enter Address" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>City</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacist)->city}}@endif" name="city" placeholder="Enter City" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Pincode</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacist)->pincode}}@endif" name="pincode" placeholder="Enter Pincode" minlength="6" maxlength="6" required number>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Country</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacist)->country}}@endif" name="country" placeholder="Enter Country" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Latitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacist)->latitude}}@endif" name="latitude" placeholder="Enter Latitude" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Longitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacist)->longitude}}@endif" name="longitude" placeholder="Enter Longitude" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Password</label>
                            <input type="password" class="form-control" value="@if($id){{Optional($pharmacist)->password}}@endif" name="password" placeholder="Enter Password" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Image</label>
                            @if($id)
                            <img src="{{asset('pharmacist_image/'.$pharmacist->image)}}" width="100" height="100">
                            @endif
                            <input type="file" class="form-control" value="@if($id){{Optional($pharmacist)->image}}@endif" name="image" placeholder="Enter Image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Banner Image</label>
                            @if($id)
                            <img src="{{asset('pharmacist_image/'.$pharmacist->banner_image)}}" width="100" height="100">
                            @endif
                            <input type="file" class="form-control" value="@if($id){{Optional($pharmacist)->banner_image}}@endif" name="banner_image" placeholder="Enter Banner Image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>


                            <button class="btn btn-primary" type="submit">Submit</button>
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