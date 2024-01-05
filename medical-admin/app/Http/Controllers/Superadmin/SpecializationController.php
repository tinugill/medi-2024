<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Toastr;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $special    =   Specialization::where('is_deleted', '0')->get();

        return view('superadmin.specialization.index', compact('special'));
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
        return view('superadmin.specialization.create', compact('id', 'special'));
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
        Specialization::create($data);
        Toastr::success('Specialization Created Successfully ', 'Success');
        return redirect()->route('specialization.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $special = Specialization::find($id);
        return view('superadmin.specialization.view', compact('special', 'id'));
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
        $special = Specialization::find($id);
        return view('superadmin.specialization.create', compact('special', 'id'));
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
        Specialization::where('id', $id)->update($data);
        Toastr::success('Specialization Update Successfully ', 'Success');
        return redirect()->route('specialization.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Specialization::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Specialization Deleted Successfully ', 'Success');
        return redirect()->route('specialization.index');
    }
}
