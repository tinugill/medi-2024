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
				<div>Procedures
				</div>
			</div>
		</div>
	</div>
	<div class="main-card mb-3 card">
		<div class="card-body">
			<h5 class="card-title">Procedures List</h5>
			@if($id)
			<form class="needs-validation" action="{{route('procedures.update',$id)}}" novalidate method="POST">
				@method('PUT')
				@else
				<form class="needs-validation" action="{{route('procedures.store')}}" novalidate method="POST">
					@endif
					@csrf

					<div class="form-row">
						@if($id)
						<div class="col-md-6 mb-3">
							<label>Status</label>
							<select type="text" class="form-control" value="@if($id){{Optional($Procedures)->is_approved}}@endif" name="is_approved" placeholder="Enter Status" required>
								<option>Select Status</option>
								<option value="1" @if($id && Optional($Procedures)->is_approved == '1'){{ 'selected'}}@endif>Approved</option>
								<option value="0" @if($id && Optional($Procedures)->is_approved == '0'){{ 'selected'}}@endif>Pending</option>
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
						@endif
						<div class="col-md-6 mb-3">
							<label>Name</label>
							<input type="text" class="form-control" value="@if($id){{Optional($Procedures)->name}}@endif" name="name" placeholder="Name" required>
							<div class="valid-feedback">
								Looks good!
							</div>
						</div>
					</div>

					<button class="btn btn-primary" type="submit">Submit form</button>
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