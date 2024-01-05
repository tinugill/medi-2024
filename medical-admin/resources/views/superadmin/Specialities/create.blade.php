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
                    Add Speciality
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Specialities</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('specialities.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('specialities.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label>Specialization</label>
                            <select name="specialization_id" class="form-control" id="specialization_id" required>
                                <option selected disabled>Please Select One</option>
                                @foreach($specialization as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $speciality->specialization_id  ? 'selected' : ''}}@endif>{{$row->degree}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Speciality Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($speciality)->speciality_name}}@endif" name="speciality_name" placeholder="Enter Speciality Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        @if($id)
                        <div class="col-md-4 mb-3">
                            <label>Status</label>
                            <select type="text" class="form-control" value="@if($id){{Optional($speciality)->is_approved}}@endif" name="is_approved" placeholder="Enter Status" required>
                                <option>Select Status</option>
                                <option value="1" @if($id && Optional($speciality)->is_approved == '1'){{ 'selected'}}@endif>Approved</option>
                                <option value="0" @if($id && Optional($speciality)->is_approved == '0'){{ 'selected'}}@endif>Pending</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        @endif

                        <div class="col-md-4 mb-3">
                            <img src="@if($id){{asset('specialities_image/'.Optional($speciality)->image)}}@endif" class="max-img">
                            <label>Speciality Image</label>
                            <input type="file" class="form-control" value="@if($id){{Optional($speciality)->image}}@endif" name="image" placeholder="Enter Speciality Name">
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