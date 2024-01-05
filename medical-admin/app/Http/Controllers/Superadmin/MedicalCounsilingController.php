<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medical_counsiling;
use Toastr;

class MedicalCounsilingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $special    =   Medical_counsiling::where('is_deleted', '0')->get();

        return view('superadmin.medical_counsling.index', compact('special'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $id = '';
        $special = '';
        return view('superadmin.medical_counsling.create', compact('id', 'special'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->except(['_token']);
        $data['is_approved'] = '1';
        Medical_counsiling::create($data);
        Toastr::success('Medical counselling Created Successfully ', 'Success');
        return redirect()->route('medical_counsling.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $special = Medical_counsiling::find($id);
        return view('superadmin.medical_counsling.view', compact('special', 'id'));
        //

    }

    /**
     * Show the form for editing the specified resourc
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $special = Medical_counsiling::find($id);
        return view('superadmin.medical_counsling.create', compact('special', 'id'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->except(['_method', '_token']);
        Medical_counsiling::where('id', $id)->update($data);
        Toastr::success('Medical counselling Update Successfully ', 'Success');
        return redirect()->route('medical_counsling.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Medical_counsiling::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Medical counselling deleted Successfully ', 'Success');
        return redirect()->route('medical_counsling.index');
    }
}
