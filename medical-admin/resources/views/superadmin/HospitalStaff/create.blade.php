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
                <div>Hospital Staff
                </div>
            </div>

        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Hospital Staff</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('hospitalstaff.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('hospitalstaff.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($hospitalstaff)->name}}@endif" name="name" placeholder="Enter Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($hospitalstaff)->email}}@endif" name="email" placeholder="Enter Email" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Mobile</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($hospitalstaff)->mobile}}@endif" name="mobile" placeholder="Enter Mobile" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Age</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($hospitalstaff)->age}}@endif" name="age" placeholder="Enter Age" required number>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($hospitalstaff)->address}}@endif" name="address" placeholder="Enter Address" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>City</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($hospitalstaff)->city}}@endif" name="city" placeholder="Enter City" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Pincode</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($hospitalstaff)->pincode}}@endif" name="pincode" placeholder="Enter Pincode" minlength="6" maxlength="6" required number>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Country</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($hospitalstaff)->country}}@endif" name="country" placeholder="Enter Country" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Password @if($id){{ '(Enter if you want to update)'}}@endif</label>
                            <input type="password" class="form-control" value="" name="password" placeholder="Enter Password" @if(!$id){{ 'required' }}@endif>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Image</label>
                            @if($id)
                            <img src="{{asset('HospitalStaff_image/'.$hospitalstaff->image)}}" class="max-img">
                            @endif
                            <input type="file" class="form-control" value="@if($id){{Optional($hospitalstaff)->image}}@endif" name="image" placeholder="Enter Image">
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