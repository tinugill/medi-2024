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
                <div>Lab Test Packages

                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Package</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('labtestpackage.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('labtestpackage.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label>Select Lab</label>
                            <select name="lab_id" class="form-control" id="lab_id" required>
                                <option selected disabled>Please Select One</option>
                                @foreach($labs as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $Labtestpackage->lab_id  ? 'selected' : ''}}@endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Select Tests</label>
                            <select name="test_ids[]" class="form-control" id="test_ids" multiple required>
                                <?php $tid = json_decode(@$Labtestpackage->test_ids, true);
                                if (!is_array($tid)) {
                                    $tid = array();
                                }
                                ?>
                                @foreach($labtest as $row)
                                <option value="{{$row->id}}" <?php if (in_array($row->id, $tid)) {
                                                                    echo 'selected';
                                                                } ?>>{{$row->test_name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Package name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($Labtestpackage)->package_name}}@endif" name="package_name" placeholder="Enter package name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Price</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($Labtestpackage)->price}}@endif" name="price" placeholder="Enter price" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Discount</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($Labtestpackage)->discount}}@endif" name="discount" placeholder="Enter discount" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Home sample collection?</label>
                            <select class="form-control" name="home_sample_collection">
                                <option value="Yes" <?php if (isset($Labtestpackage->home_sample_collection) && $Labtestpackage->home_sample_collection == 'Yes') {
                                                        echo 'selected';
                                                    } ?>>Yes</option>
                                <option value="No" <?php if (isset($Labtestpackage->home_sample_collection) && $Labtestpackage->home_sample_collection == 'No') {
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
                                <option value="Yes" <?php if (isset($Labtestpackage->report_home_delivery) && $Labtestpackage->report_home_delivery == 'Yes') {
                                                        echo 'selected';
                                                    } ?>>Yes</option>
                                <option value="No" <?php if (isset($Labtestpackage->report_home_delivery) && $Labtestpackage->report_home_delivery == 'No') {
                                                        echo 'selected';
                                                    } ?>>No</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Ambulance Available?</label>
                            <select class="form-control" name="ambulance_available">
                                <option value="Yes" <?php if (isset($Labtestpackage->ambulance_available) && $Labtestpackage->ambulance_available == 'Yes') {
                                                        echo 'selected';
                                                    } ?>>Yes</option>
                                <option value="No" <?php if (isset($Labtestpackage->ambulance_available) && $Labtestpackage->ambulance_available == 'No') {
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
                            <img src="{{asset('laboratorist_image/'.$Labtestpackage->image)}}" width="20" height="20">
                            @endif
                            <input type="file" class="form-control" value="@if($id){{Optional($Labtestpackage)->image}}@endif" name="image" placeholder="Enter Image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                </form>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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

                    $(document).ready(function() {
                        $('select[name="lab_id"]').on('change', function() {
                            var categoryId = $(this).val();

                            if (categoryId) {
                                $.ajax({
                                    url: 'labtest/ajax/' + categoryId,
                                    type: "GET",
                                    dataType: "json",
                                    success: function(data) {

                                        console.log(data);
                                        $('select[name="test_ids"]').empty();
                                        $.each(data, function(key, value) {
                                            console.log(value);
                                            $('select[name="test_ids"]').append('<option value="' + key + '">' + value.test_name + '</option>');
                                        });


                                    }
                                });
                            } else {
                                $('select[name="test_ids"]').empty();
                            }
                        });
                    });
                </script>
        </div>
    </div>
    @endsection