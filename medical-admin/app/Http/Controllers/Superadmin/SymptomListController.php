<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SymptomsList;
use Toastr;

class SymptomListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $special    =   SymptomsList::where('is_deleted', '0')->get();

        return view('superadmin.symptom_list.index', compact('special'));
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
        return view('superadmin.symptom_list.create', compact('id', 'special'));
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
        SymptomsList::create($data);
        Toastr::success('Info Created Successfully ', 'Success');
        return redirect()->route('symptom_list.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $special = SymptomsList::find($id);
        return view('superadmin.symptom_list.view', compact('special', 'id'));
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
        $special = SymptomsList::find($id);
        return view('superadmin.symptom_list.create', compact('special', 'id'));
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
        SymptomsList::where('id', $id)->update($data);
        Toastr::success('Info Update Successfully ', 'Success');
        return redirect()->route('symptom_list.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        SymptomsList::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Info deleted Successfully ', 'Success');
        return redirect()->route('symptom_list.index');
    }
}
