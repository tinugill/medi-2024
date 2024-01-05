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
                <div>Specialities
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Specialities</h5>
                    <div class="table-responsive">
                        <table class="mb-0 table">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Image </th>
                                    <th>Specialization </th>
                                    <th>Speciality </th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($special as $key=>$value)
                                <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td> @if($value->image != '')
                                        <img src="{{asset('specialities_image/'.$value->image)}}" width="100" height="100">
                                        @endif
                                    </td>
                                    <td>{{@$value->specialization->degree}}</td>
                                    <td>{{$value->speciality_name}}</td>
                                    <td> @if($value->is_approved == '1')
                                        <span class="badge badge-pill badge-success">Approved</span>
                                        @else
                                        <span class="badge badge-pill badge-warning">Not approved</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{route('specialities.destroy',$value->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning">Delete</button>
                                        </form>

                                        <a href="{{route('specialities.edit',$value->id)}}"> <button type="submit" class="btn btn-success">Update</button></a>
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