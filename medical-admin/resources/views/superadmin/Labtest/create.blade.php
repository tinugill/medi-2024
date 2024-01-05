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
                <div>Lab Test

                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Tests</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('labtest.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('labtest.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label>Select Lab</label>
                            <select name="lab_id" class="form-control" id="lab_id" required>
                                <option selected disabled>Please Select One</option>
                                @foreach($labs as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $labtest->lab_id  ? 'selected' : ''}}@endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Select Category</label>
                            <select name="category_id" class="form-control" id="category_id" required>
                                <option selected disabled>Please Select One</option>
                                @foreach($category as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $labtest->category_id  ? 'selected' : ''}}@endif>{{$row->title}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Test name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($labtest)->test_name}}@endif" name="test_name" placeholder="Enter test name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Price</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($labtest)->price}}@endif" name="price" placeholder="Enter price" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Discount</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($labtest)->discount}}@endif" name="discount" placeholder="Enter discount" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Prerequisite</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($labtest)->prerequisite}}@endif" name="prerequisite" placeholder="Ex: empty stomach in morning">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Home sample collection?</label>
                            <select class="form-control" name="home_sample_collection">
                                <option value="Yes" <?php if (isset($labtest->home_sample_collection) && $labtest->home_sample_collection == 'Yes') {
                                                        echo 'selected';
                                                    } ?>>Yes</option>
                                <option value="No" <?php if (isset($labtest->home_sample_collection) && $labtest->home_sample_collection == 'No') {
                                                        echo 'selected';
                                                    } ?>>No</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Report home delivery?</label>
                            <select class="form-control" name="report_home_delivery">
                                <option value="Yes" <?php if (isset($labtest->report_home_delivery) && $labtest->report_home_delivery == 'Yes') {
                                                        echo 'selected';
                                                    } ?>>Yes</option>
                                <option value="No" <?php if (isset($labtest->report_home_delivery) && $labtest->report_home_delivery == 'No') {
                                                        echo 'selected';
                                                    } ?>>No</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Ambilance Available?</label>
                            <select class="form-control" name="ambulance_available">
                                <option value="Yes" <?php if (isset($labtest->ambulance_available) && $labtest->ambulance_available == 'Yes') {
                                                        echo 'selected';
                                                    } ?>>Yes</option>
                                <option value="No" <?php if (isset($labtest->ambulance_available) && $labtest->ambulance_available == 'No') {
                                                        echo 'selected';
                                                    } ?>>No</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Is Approved?</label>
                            <select class="form-control" name="is_approved">
                                <option value="1" <?php if (isset($labtest->is_approved) && $labtest->is_approved == '1') {
                                                        echo 'selected';
                                                    } ?>>Yes</option>
                                <option value="0" <?php if (isset($labtest->is_approved) && $labtest->is_approved == '0') {
                                                        echo 'selected';
                                                    } ?>>No</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Image</label>
                            @if($id)
                            <img src="{{asset('laboratorist_image/'.$labtest->image)}}" width="20" height="20">
                            @endif
                            <input type="file" class="form-control" value="@if($id){{Optional($labtest)->image}}@endif" name="image" placeholder="Enter Image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
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