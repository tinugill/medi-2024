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
                <div>
                    Bloodbankstock
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Bloodbankstock</h5>
                    <div class="table-responsive">
                        <table class="mb-0 table">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Component Name </th>
                                    <th>Avialablity </th>
                                    <th>Available unit </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bloodbankstock as $key=>$value)
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td>{{$value->component_name}}</td>
                                    <td>{{$value->avialablity}}</td>
                                    <td>{{$value->available_unit}}</td>

                                    <td>
                                        <form action="{{route('bloodbankstock.destroy',$value->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning">Delete</button>
                                        </form>

                                        <a href="{{route('bloodbankstock.edit',$value->id)}}"> <button type="submit" class="btn btn-success">Update</button></a>
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