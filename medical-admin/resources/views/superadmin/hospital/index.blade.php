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
                <div>Hospitals
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Hospital List</h5>
                    <div class="table-responsive">
                        <table class="mb-0 table">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Pincode</th>
                                    <th>Beds Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hospital as $key=>$value)
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td><img src="{{asset('hospital_image/'.$value->image)}}" width="100" height="100"></td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->address}}</td>
                                    <td>{{$value->city}}</td>
                                    <td>{{$value->pincode}}</td>
                                    <td>{{$value->country}}</td>
                                    <td>{{$value->beds_quantity}}</td>

                                    <td>
                                        <form action="{{route('hospital.destroy',$value->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning">Delete</button>
                                        </form>

                                        <a href="{{route('hospital.edit',$value->id)}}"> <button type="submit" class="btn btn-success">Update</button></a>
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