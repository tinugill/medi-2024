<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Procedures;
use Session;
use Cache;
use Toastr;


class ProceduresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Procedures    =   Procedures::where('is_deleted', '0')->get();
        return view('superadmin.Procedures.index', compact('Procedures'));
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
        $Procedures = '';

        return view('superadmin.Procedures.create', compact('id', 'Procedures'));
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
        Procedures::create($data);
        Toastr::success('Procedures Created Successfully ', 'Success');
        return redirect()->route('procedures.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Procedures = Procedures::find($id);
        return view('superadmin.Procedures.view', compact('Procedures'));
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Procedures = Procedures::find($id);
        return view('superadmin.Procedures.create', compact('Procedures', 'id'));
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
        Procedures::where('id', $id)->update($data);
        Toastr::success('Procedures Updated Successfully ', 'Success');
        return redirect()->route('procedures.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Procedures::where('id', $id)->update(['is_deleted' => 1]);
        Toastr::success('Procedures Deleted Successfully ', 'Success');
        return redirect()->route('procedures.index');
    }
}
