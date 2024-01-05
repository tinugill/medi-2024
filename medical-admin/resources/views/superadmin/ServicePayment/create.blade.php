
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
                <div>Service Priving Details

                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Enter Details</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('service_payment.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('service_payment.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label>Title</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($category)->title}}@endif" name="title" placeholder="Enter Title" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                       
                        <div class="col-md-4 mb-3">
                            <label>Price (1 month subscription)</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($category)->price}}@endif" name="price" placeholder="Enter price" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Discount (1 month subscription)</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($category)->discount}}@endif" name="discount" placeholder="Enter discount">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Price (4 month subscription)</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($category)->price_4}}@endif" name="price_4" placeholder="Enter price" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Discount (4 month subscription)</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($category)->discount_4}}@endif" name="discount_4" placeholder="Enter discount">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Price (6 month subscription)</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($category)->price_6}}@endif" name="price_6" placeholder="Enter price" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Discount (6 month subscription)</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($category)->discount_6}}@endif" name="discount_6" placeholder="Enter discount">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Price (1 year subscription)</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($category)->price_12}}@endif" name="price_12" placeholder="Enter price" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Discount (1 year subscription)</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($category)->discount_12}}@endif" name="discount_12" placeholder="Enter discount">
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