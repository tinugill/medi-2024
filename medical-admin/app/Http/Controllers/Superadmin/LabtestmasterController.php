<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Labtest_masterdb;
use Toastr;

class LabtestmasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $special    =   Labtest_masterdb::where('is_deleted', '0')->get();

        return view('superadmin.labtest_masterdb.index', compact('special'));
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
        return view('superadmin.labtest_masterdb.create', compact('id', 'special'));
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
        Labtest_masterdb::create($data);
        Toastr::success('Info Created Successfully ', 'Success');
        return redirect()->route('labtest_masterdb.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $special = Labtest_masterdb::find($id);
        return view('superadmin.labtest_masterdb.view', compact('special', 'id'));
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
        $special = Labtest_masterdb::find($id);
        return view('superadmin.labtest_masterdb.create', compact('special', 'id'));
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
        Labtest_masterdb::where('id', $id)->update($data);
        Toastr::success('Info Update Successfully ', 'Success');
        return redirect()->route('labtest_masterdb.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Labtest_masterdb::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Info deleted Successfully ', 'Success');
        return redirect()->route('labtest_masterdb.index');
    }
}
