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
				<div>Add Hospital
				</div>
			</div>
		</div>
	</div>
	<div class="main-card mb-3 card">
		<div class="card-body">
			<h5 class="card-title">Hospital Form</h5>
			@if($id)
			<form class="needs-validation" action="{{route('hospital.update',$id)}}" novalidate enctype="multipart/form-data" method="POST">
				@method('PUT')
				@else
				<form class="needs-validation" action="{{route('hospital.store')}}" novalidate enctype="multipart/form-data" method="POST">
					@endif
					@csrf
					<div class="form-row">
						<div class="col-md-4 mb-3">
							<label>Logo Image
								@if($id)
								<a href="{{asset('hospital_image/'.$hospital->image)}} " width="100" height="100">View File</a>
								@endif
							</label>
							<input type="file" class="form-control" name="image" placeholder="image" @if(!$id){{ 'required' }}@endif>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Establishment Name</label>
							<input type="text" class="form-control" value="@if($id){{Optional($hospital)->name}}@endif" name="name" placeholder="Name" required>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Contact Number</label>
							<input type="text" class="form-control" value="@if($id){{Optional($hospital)->phone_no}}@endif" name="phone_no" placeholder="Name" required>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<label>About</label>
							<textarea type="text" class="form-control" name="about" placeholder="about" required>@if($id){{Optional($hospital)->about}}@endif</textarea>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<label>Address</label>
							<textarea type="text" class="form-control" name="address" placeholder="Address" required>@if($id){{Optional($hospital)->address}}@endif</textarea>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-3">
							<label>City</label>
							<input type="text" class="form-control" value="@if($id){{Optional($hospital)->city}}@endif" name="city" placeholder="city" required>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Pincode</label>
							<input type="text" class="form-control" value="@if($id){{Optional($hospital)->pincode}}@endif" name="pincode" placeholder="pincode" required>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Country</label>
							<input type="text" class="form-control" value="@if($id){{Optional($hospital)->country}}@endif" name="country" placeholder="country" required>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Beds Quantity</label>
							<input type="text" class="form-control" value="@if($id){{Optional($hospital)->beds_quantity}}@endif" name="beds_quantity" placeholder="Beds Quantity" required>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Registration details</label>
							<input type="text" class="form-control" value="@if($id){{Optional($hospital)->registration_details}}@endif" name="registration_details" placeholder="" required>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Registration Document
								@if($id)
								<a href="{{asset('hospital_image/'.$hospital->registration_file)}} " width="100" height="100">View File</a>
								@endif
							</label>
							<input type="file" class="form-control" name="image" placeholder="registration_file" @if(!$id){{ 'required' }}@endif>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-3 mb-3">
							<label>Accredition details</label>
							<select class="form-control" name="accredition_details">
								<option value="ISO" @if($id){{$hospital->accredition_details == 'ISO'     ? 'selected' : ''}}@endif>ISO</option>
								<option value="QCI" @if($id){{$hospital->accredition_details == 'QCI'     ? 'selected' : ''}}@endif>QCI</option>
								<option value="NABH" @if($id){{$hospital->accredition_details == 'NABH'     ? 'selected' : ''}}@endif>NABH</option>
								<option value="Other" @if($id){{$hospital->accredition_details == 'Other'     ? 'selected' : ''}}@endif>Other</option>
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-3 mb-3">
							<label>Accredition certificate
								@if($id)
								<a href="{{asset('hospital_image/'.$hospital->accredition_certificate)}} " width="100" height="100">View File</a>
								@endif
							</label>
							<input type="file" class="form-control" name="image" placeholder="accredition_certificate" @if(!$id){{ 'required' }}@endif>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-3 mb-3">
							<label>Latitude</label>
							<input type="text" class="form-control" value="@if($id){{Optional($hospital)->latitude}}@endif" name="latitude" placeholder="Latitude">
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-3 mb-3">
							<label>Longitude</label>
							<input type="text" class="form-control" value="@if($id){{Optional($hospital)->longitude}}@endif" name="longitude" placeholder="Longitude">
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Specialities</label>
							<?php $sid =  json_decode(@$hospital->specialities_id, true); ?>
							<select class="form-control" name="specialities_id[]" multiple required>
								@foreach($specialities as $special)
								<option value="{{$special->id}}" @if($id){{in_array($special->id,$sid)     ? 'selected' : ''}}@endif>{{$special->speciality_name}}</option>
								@endforeach
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Procedures</label>
							<?php $prid =  json_decode(@$hospital->procedures_id, true); ?>
							<select class="form-control" name="procedures_id[]" multiple required>
								@foreach($procedure as $p)
								<option value="{{$p->id}}" @if($id){{in_array($p->id,$prid)  ? 'selected' : ''}}@endif>{{$p->name}}</option>
								@endforeach
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Facilities</label>
							<?php $fcid =  json_decode(@$hospital->facilities_avialable, true); ?>
							<select class="form-control" name="facilities_avialable[]" multiple required>
								@foreach($Facilities as $p)
								<option value="{{$p->id}}" @if($id){{in_array($p->id,$fcid)  ? 'selected' : ''}}@endif>{{$p->title}}</option>
								@endforeach
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Empanelments</label>
							<?php $fcid =  json_decode(@$hospital->empanelments, true); ?>
							<select class="form-control" name="empanelments[]" multiple required>
								@foreach($Empanelments as $p)
								<option value="{{$p->id}}" @if($id){{in_array($p->id,$fcid)  ? 'selected' : ''}}@endif>{{$p->title}}</option>
								@endforeach
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>

						<div class="col-md-4 mb-3">
							<label>Type</label>
							<select class="form-control" name="type">
								<option value="Hospital" @if($id){{$hospital->type == 'Hospital'     ? 'selected' : ''}}@endif>Hospital</option>
								<option value="Clinic" @if($id){{$hospital->type == 'Clinic'     ? 'selected' : ''}}@endif>Clinic</option>
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Contact person name</label>
							<input type="text" class="form-control" value="@if($id){{Optional($User)->name}}@endif" name="contact_person_name" required>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Contact person email (login email)</label>
							<input type="text" class="form-control" value="@if($id){{Optional($User)->email}}@endif" name="email" required>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Contact person mobile number</label>
							<input type="text" class="form-control" value="@if($id){{Optional($User)->mobile}}@endif" name="mobile" required>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label>Login Password @if($id){{ '(Enter if want to change)' }}@endif</label>
							<input type="text" class="form-control" name="password" @if(!$id){{ 'required' }}@endif>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>

						<div class="col-md-4 mb-3">
							<label>Slug</label>
							<input type="text" class="form-control" value="@if($id){{Optional($hospital)->slug}}@endif" name="slug" placeholder="slug">
							<span class="text-danger">{{ $errors->first('slug') }}</span>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
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
</div>

@endsection