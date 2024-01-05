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
                <div>Bloodbankstock
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Create Bloodbankstock</h5>
            @if($id)
            <form class="needs-validation" novalidate method="POST" action="{{route('bloodbankstock.update',$id)}}" enctype="multipart/form-data">
                @method('PUT')
                @else
                <form class="needs-validation" novalidate method="POST" action="{{route('bloodbankstock.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label>Component Name</label>
                            <select name="component_name" class="form-control" id="component_name" required>
                                <option selected disabled>Please Select One</option>
                                @foreach($BloodbankComponent as $row)
                                <option value="{{$row->title}}" @if($id){{$row->title ==  $bloodbankstock->component_name  ? 'selected' : ''}}@endif>{{$row->title}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Hospital Name</label>
                            <select name="avialablity" class="form-control" id="avialablity">
                                <option selected value="0">Please Select One</option>

                                <option value="Yes" @if($id){{ $bloodbankstock->avialablity == 'Yes'  ? 'selected' : ''}}@endif>Yes</option>
                                <option value="No" @if($id){{ $bloodbankstock->avialablity == 'No'  ? 'selected' : ''}}@endif>No</option>

                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Available unit</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($bloodbankstock)->available_unit}}@endif" name="available_unit" required>
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