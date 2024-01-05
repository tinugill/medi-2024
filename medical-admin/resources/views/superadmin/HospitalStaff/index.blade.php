@extends('superadmin.layouts.master_after_login')
@section('content')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
                    </i>
                </div>
                <div>Hospital Staff
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Hospital Staff</h5>
                    <div class="table-responsive">
                        <table class="mb-0 table">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Image </th>
                                    <th>Name </th>
                                    <th>Email </th>
                                    <th>Mobile</th>
                                    <th>Age</th>
                                    <th>Address </th>
                                    <th>City</th>
                                    <th>Pincode </th>
                                    <th>Country</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hospitalstaff as $key=>$value)
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td><img src="{{asset('HospitalStaff_image/'.$value->image)}}" width="100" height="100"></td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->email}}</td>
                                    <td>{{$value->mobile}}</td>
                                    <td>{{$value->age}}</td>
                                    <td>{{$value->address}}</td>
                                    <td>{{$value->city}}</td>
                                    <td>{{$value->pincode}}</td>
                                    <td>{{$value->country}}</td>

                                    <td>
                                        <form action="{{route('hospitalstaff.destroy',$value->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning">Delete</button>
                                        </form>

                                        <a href="{{route('hospitalstaff.edit',$value->id)}}"> <button type="submit" class="btn btn-success">Update</button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection