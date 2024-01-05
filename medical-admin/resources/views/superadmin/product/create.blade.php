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
                    Products
                </div>
            </div>
            <div class="page-title-actions">
                <button type="button" data-toggle="tooltip" title="Example Tooltip" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark">
                    <i class="fa fa-star"></i>
                </button>
                <div class="d-inline-block dropdown">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fa fa-business-time fa-w-20"></i>
                        </span>
                        Buttons
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <i class="nav-link-icon lnr-inbox"></i>
                                    <span>
                                        Inbox
                                    </span>
                                    <div class="ml-auto badge badge-pill badge-secondary">86</div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <i class="nav-link-icon lnr-book"></i>
                                    <span>
                                        Book
                                    </span>
                                    <div class="ml-auto badge badge-pill badge-danger">5</div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <i class="nav-link-icon lnr-picture"></i>
                                    <span>
                                        Picture
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a disabled href="javascript:void(0);" class="nav-link disabled">
                                    <i class="nav-link-icon lnr-file-empty"></i>
                                    <span>
                                        File Disabled
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Product Form</h5>
            @if($id)
            <form class="needs-validation" action="{{route('product.update',$id)}}" novalidate enctype="multipart/form-data" method="POST">
                @method('PUT')
                @else
                <form class="needs-validation" action="{{route('product.store')}}" novalidate enctype="multipart/form-data" method="POST">
                    @endif
                    @csrf
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label>Pharmacy</label>
                            <select name="pharmacy_id" class="form-control" id="pharmacy_id" required>
                                <option selected disabled>Please Select One</option>
                                @foreach($pharmacy as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $product->pharmacy_id  ? 'selected' : ''}}@endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Brand Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($product)->title}}@endif" name="title" placeholder="Tilte" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Type of formulation</label>
                            <select name="formulation_id" class="form-control" id="formulation_id" required>
                                <option selected disabled>Please Select One</option>
                                @foreach($Formulation as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $product->formulation_id  ? 'selected' : ''}}@endif>{{$row->title}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Strength</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($product)->strength}}@endif" name="strength" placeholder="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Varient Name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($product)->variant_name}}@endif" name="variant_name" placeholder="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>MRP</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($product)->mrp}}@endif" name="mrp" placeholder="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Discount</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($product)->discount}}@endif" name="discount" placeholder="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Category</label>
                            <select name="category_id" class="form-control" id="category_id" required>
                                <option selected disabled>Please Select One</option>
                                @foreach($categories as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id ==  $product->category_id  ? 'selected' : ''}}@endif>{{$row->title}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <!-- <div class="col-md-4 mb-3">
                            <label>Sub-Category</label>
                            <select name="sub_category_id" class="form-control" id="sub_category_id" required>
                                <option selected disabled>Please Select One</option>
                                @if($id)
                                @foreach($subcat as $row)
                                <option value="{{$row->id}}" @if($id){{$row->id == $product->sub_category_id  ? 'selected' : ''}}@endif>{{$row->title}}</option>
                                @endforeach
                                @endif
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        -->
                        <div class="col-md-4 mb-3">
                            <label>Salt name</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($product)->salt_name}}@endif" name="salt_name" placeholder="">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Availiblity</label>
                            <select name="avaliblity" class="form-control" id="avaliblity" required>
                                <option selected disabled>Please Select</option>
                                <option value="Yes" @if($id){{ $product->avaliblity == 'Yes'  ? 'selected' : ''}}@endif>Yes</option>
                                <option value="No" @if($id){{ $product->avaliblity == 'No'  ? 'selected' : ''}}@endif>No</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Prescription required</label>
                            <select name="prescription_required" class="form-control" id="prescription_required" required>
                                <option selected disabled>Please Select</option>
                                <option value="Yes" @if($id){{ $product->prescription_required == 'Yes'  ? 'selected' : ''}}@endif>Yes</option>
                                <option value="No" @if($id){{ $product->prescription_required == 'No'  ? 'selected' : ''}}@endif>No</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Company</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($product)->manufacturer_name}}@endif" name="manufacturer_name" placeholder="Company Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Description</label>
                            <textarea type="text" class="form-control" name="product_description" placeholder="Description" required>@if($id){{Optional($product)->description}}@endif</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Expiry Type</label>
                            <select name="expiry_type" class="form-control" id="expiry_type" required>
                                <option selected disabled>Please Select</option>
                                <option value="on" @if($id){{ $product->expiry_type == 'on'  ? 'selected' : ''}}@endif>On</option>
                                <option value="after" @if($id){{ $product->expiry_type == 'after'  ? 'selected' : ''}}@endif>After</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Expiry Month</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($product)->expiry_month}}@endif" name="expiry_month"  required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Expiry Year</label>
                            <input type="number" class="form-control" value="@if($id){{Optional($product)->expiry_year}}@endif" name="expiry_year"  required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label>Manufacturer Address</label>
                            <textarea type="text" class="form-control" name="manufacturer_address" placeholder="Manufacturer Address" required>@if($id){{Optional($product)->manufacturer_address}}@endif</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <!-- <div class="col-md-4 mb-3">
                            <label>Benefits</label>
                            <textarea class="form-control" name="benefits" placeholder="Benefits">@if($id){{Optional($product)->benefits}}@endif</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Ingredients</label>
                            <textarea class="form-control" name="ingredients" placeholder="Ingredients">@if($id){{Optional($product)->ingredients}}@endif</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Uses</label>
                            <textarea class="form-control" name="uses" placeholder="Uses">@if($id){{Optional($product)->uses}}@endif</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div> -->

                        <div class="col-md-3 mb-3 field_wrapper">
                            <label>Image</label>
                            @if($id)
                            <img src="{{asset('product_image/'.$product->image)}}" width="100" height="100">
                            @endif
                            <input type="file" class="form-control" name="image" placeholder="Image">

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 field_wrapper">
                            <label>Image 2</label>
                            @if($id)
                            <img src="{{asset('product_image/'.$product->image_2)}}" width="100" height="100">
                            @endif
                            <input type="file" class="form-control" name="image_2" placeholder="Image">

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 field_wrapper">
                            <label>Image 3</label>
                            @if($id)
                            <img src="{{asset('product_image/'.$product->image_3)}}" width="100" height="100">
                            @endif
                            <input type="file" class="form-control" name="image_3" placeholder="Image">

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 field_wrapper">
                            <label>Image 4</label>
                            @if($id)
                            <img src="{{asset('product_image/'.$product->image_4)}}" width="100" height="100">
                            @endif
                            <input type="file" class="form-control" name="image_4" placeholder="Image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>



                        <div class="col-md-4 mb-3">
                            <label>Slug</label>
                            <input type="text" class="form-control" value="@if($id){{Optional($product)->slug}}@endif" name="slug" placeholder="slug">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div ><input type="file" class="form-control"  value="" name="image[]" placeholder="Product Image"  required><a href="javascript:void(0);" class="remove_button"><img src="{{asset("assets/images/remove-icon.png")}}"/></a><div class="valid-feedback">Looks good!</div></div>'; //New input field html 
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });

    $(document).ready(function() {
        var maxFieldMrp = 10; //Input fields increment limitation
        var addButtonMrp = $('.add_button_mrp'); //Add button selector
        var wrapperMrp = $('.field_wrapper_mrp'); //Input field wrapper
        var fieldHTMLMrp = '<div class="row"><div class="col-md-3"><input type="text" class="form-control"  name="mrp[]" placeholder="MRP" value="@if($id){{Optional($product)->mrp}}@endif" required></input><div class="valid-feedback">Looks good!</div></div><div  class="col-md-3"><input type="text" class="form-control"  name="discount[]" placeholder="Discount" value="@if($id){{Optional($product)->discount}}@endif" required></input><div class="valid-feedback">Looks good!</div></div><div  class="col-md-3"><input type="text" class="form-control"  name="p_name[]" placeholder="Discount" value="@if($id){{Optional($product)->p_name}}@endif" required></input><div class="valid-feedback">Looks good!</div></div><div  class="col-md-3"><input type="text" class="form-control"  name="description[]" placeholder="Composition/Strength" value="@if($id){{Optional($product)->description}}@endif" required></input><a href="javascript:void(0);" class="remove_button_mrp"><img src="{{asset("assets/images/remove-icon.png")}}"/></a><div class="valid-feedback">Looks good!</div></div></div>'; //New input field html 
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButtonMrp).click(function() {
            //Check maximum number of input fields
            if (x < maxFieldMrp) {
                x++; //Increment field counter
                $(wrapperMrp).append(fieldHTMLMrp); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapperMrp).on('click', '.remove_button_mrp', function(e) {
            e.preventDefault();
            $(this).parent('.col-md-4').parent('.row').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });

    $(document).ready(function() {
        $('select[name="category_id"]').on('change', function() {
            var categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: 'subcategory/ajax/' + categoryId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        console.log(data);
                        $('select[name="sub_category_id"]').empty();
                        $.each(data, function(key, value) {
                            console.log(value);
                            $('select[name="sub_category_id"]').append('<option value="' + key + '">' + value.title + '</option>');
                        });


                    }
                });
            } else {
                $('select[name="sub_category_id"]').empty();
            }
        });
    });
</script>