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
                <div>Pharmacy
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Pharmacy</h5>
                    <div class="table-responsive">
                        <table class="mb-0 table">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Name </th>
                                    <th>Email </th>
                                    <th>Mobile</th>
                                    <th>Image </th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pharmacy as $key=>$value)
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->email}}</td>
                                    <td>{{$value->mobile}}</td>
                                    <td><img src="{{asset('pharmacy_image/'.$value->image)}}" width="100" height="100"></td>
                                    <td>
                                    <td>
                                        <form action="{{route('pharmacy.destroy',$value->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning">Delete</button>
                                        </form>

                                        <a href="{{route('pharmacy.edit',$value->id)}}"> <button type="submit" class="btn btn-success">Update</button></a>
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