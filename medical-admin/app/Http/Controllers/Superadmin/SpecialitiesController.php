<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialities;
use App\Models\Specialization;
use Toastr;


class SpecialitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $special    =   Specialities::with('specialization')->where('is_deleted', '0')->get();
        return view('superadmin.Specialities.index', compact('special'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = '';
        $specialization = Specialization::all();
        $Specialities = '';
        return view('superadmin.Specialities.create', compact('id', 'specialization', 'Specialities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $specialities = new Specialities;
        $specialities->specialization_id    = $request->specialization_id;
        $specialities->speciality_name      = $request->speciality_name;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/specialities_image');
            $file->move($destinationPath, $fileName);
            $specialities->image = $fileName;
        }
        $specialities->is_approved = '1';
        $specialities->save();
        Toastr::success('Specialities Created Successfully ', 'Success');
        return redirect()->route('specialities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $special = Specialities::find($id);
        return view('superadmin.Specialities.view', compact('special', 'id'));
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
        $speciality = Specialities::find($id);
        $specialization = Specialization::all();
        return view('superadmin.Specialities.create', compact('speciality', 'id', 'specialization'));
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
        $specialities = Specialities::find($id);
        $specialities->is_approved    = $request->is_approved;
        $specialities->specialization_id    = $request->specialization_id;
        $specialities->speciality_name      = $request->speciality_name;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/specialities_image');
            $file->move($destinationPath, $fileName);
            $specialities->image = $fileName;
        }
        $specialities->save();
        Toastr::success('Specialities Update Successfully ', 'Success');
        return redirect()->route('specialities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Specialities::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Specialities Deleted Successfully ', 'Success');
        return redirect()->route('specialities.index');
    }
}
