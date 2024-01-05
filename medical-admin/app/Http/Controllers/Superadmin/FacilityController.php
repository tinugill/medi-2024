<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facilities;
use Toastr;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $special    =   Facilities::where('is_deleted', '0')->get();

        return view('superadmin.facility_list.index', compact('special'));
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
        return view('superadmin.facility_list.create', compact('id', 'special'));
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
        Facilities::create($data);
        Toastr::success('Facility Created Successfully ', 'Success');
        return redirect()->route('facility_list.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $special = Facilities::find($id);
        return view('superadmin.facility_list.view', compact('special', 'id'));
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
        $special = Facilities::find($id);
        return view('superadmin.facility_list.create', compact('special', 'id'));
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
        Facilities::where('id', $id)->update($data);
        Toastr::success('Facility Update Successfully ', 'Success');
        return redirect()->route('facility_list.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Facilities::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Facility deleted Successfully ', 'Success');
        return redirect()->route('facility_list.index');
    }
}
