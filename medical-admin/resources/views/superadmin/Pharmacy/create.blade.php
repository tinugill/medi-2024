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
                <div>Pharmacy
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Pharmacy</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('pharmacy.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('pharmacy.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->name}}@endif" name="name" placeholder="Enter Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <!-- <div class="col-md-4 mb-3">
                            <label>Hospital Name</label>
                            <select name="hospital_id" class="form-control" id="hospital_id" >
                                <option selected disabled>Please Select One</option>
                                @foreach($hospital as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $pharmacy->hospital_id  ? 'selected' : ''}}@endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div> -->
                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->email}}@endif" name="email" placeholder="Enter Email" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Mobile</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->mobile}}@endif" name="mobile" placeholder="Enter Mobile" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->address}}@endif" name="address" placeholder="Enter Address" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>City</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->city}}@endif" name="city" placeholder="Enter City" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Pincode</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->pincode}}@endif" name="pincode" placeholder="Enter Pincode" minlength="6" maxlength="6"  number>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Country</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->country}}@endif" name="country" placeholder="Enter Country" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Password @if($id){{ '(Enter if want to change)' }}@endif</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter Password" @if(!$id){{ '' }}@endif>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Owner name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->owner_name}}@endif" name="owner_name" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Owner Id Proof @if($id)
                                <a href="{{asset('pharmacy_image/'.$pharmacy->owner_id)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" value="@if($id){{Optional($pharmacy)->owner_id}}@endif" name="owner_id">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Partner name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->partner_name}}@endif" name="partner_name" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Partner Id Proof @if($id)
                                <a href="{{asset('pharmacy_image/'.$pharmacy->partner_id)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" value="@if($id){{Optional($pharmacy)->partner_id}}@endif" name="partner_id">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Pharmacist name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->pharmacist_name}}@endif" name="pharmacist_name" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Pharmacist registration number</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->pharmacist_regis_no}}@endif" name="pharmacist_regis_no" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Pharmacist Registration Certificate @if($id)
                                <a href="{{asset('pharmacy_image/'.$pharmacy->pharmacist_regis_upload)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" value="@if($id){{Optional($pharmacy)->pharmacist_regis_upload}}@endif" name="pharmacist_regis_upload">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Gstin</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->gstin}}@endif" name="gstin" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Gstin Certificate @if($id)
                                <a href="{{asset('pharmacy_image/'.$pharmacy->gstin_certificate)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" value="@if($id){{Optional($pharmacy)->gstin_certificate}}@endif" name="gstin_certificate">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Latitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->latitude}}@endif" name="latitude" placeholder="Enter Latitude" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Longitude</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->longitude}}@endif" name="longitude" placeholder="Enter Longitude" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Fax</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->fax}}@endif" name="fax" placeholder="Enter fax" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Drug Liscence Number</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->drug_liscence_number}}@endif" name="drug_liscence_number" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Drug Liscence Valid Upto</label>
                            <input type="date" class="form-control" value="@if($id){{Optional($pharmacy)->drug_liscence_valid_upto}}@endif" name="drug_liscence_valid_upto" placeholder="" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Drug Liscence Certificate @if($id)
                                <a href="{{asset('pharmacy_image/'.$pharmacy->drug_liscence_file)}}" target="_blank">View Image</a>
                                @endif </label>
                            <input type="file" class="form-control" value="@if($id){{Optional($pharmacy)->drug_liscence_file}}@endif" name="drug_liscence_file">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Slug</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($pharmacy)->slug}}@endif" name="slug" placeholder="Enter slug" >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Image</label>
                            @if($id)
                            <a href="{{asset('pharmacy_image/'.$pharmacy->image)}}" target="_blank">View Image</a>
                            @endif
                            <input type="file" class="form-control" value="@if($id){{Optional($pharmacy)->image}}@endif" name="image" placeholder="Enter Image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Banner Image</label>
                            @if($id)
                            <a href="{{asset('pharmacy_image/'.$pharmacy->banner_image)}}" target="_blank">View Image</a>
                            @endif
                            <input type="file" class="form-control" value="@if($id){{Optional($pharmacy)->banner_image}}@endif" name="banner_image" placeholder="Enter Banner Image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
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