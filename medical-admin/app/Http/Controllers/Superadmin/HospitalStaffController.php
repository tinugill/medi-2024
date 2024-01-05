<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospital_Staff;
use Toastr;
use Validator;
use Hash;


class HospitalStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $hospitalstaff    =   Hospital_Staff::where('is_deleted', '0')->get();

        return view('superadmin.HospitalStaff.index', compact('hospitalstaff'));
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
        $hospitalstaff = '';
        return view('superadmin.HospitalStaff.create', compact('id', 'hospitalstaff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:png,jpeg,jpg',
            'name' => 'required',
            'email' => 'required|email|unique:hospital__staff,email',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'country' => 'required',
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('hospitalstaff.create');
        } else {

            $hospitalstaff = new Hospital_Staff;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/HospitalStaff_image');
                $file->move($destinationPath, $fileName);
                $hospitalstaff->image = $fileName;
            }
            $hospitalstaff->name    = $data['name'];
            $hospitalstaff->email    = $data['email'];
            $hospitalstaff->address = $data['address'];
            $hospitalstaff->mobile  = $data['mobile'];
            $hospitalstaff->age     = $data['age'];
            $hospitalstaff->city    = $data['city'];
            $hospitalstaff->pincode = $data['pincode'];
            $hospitalstaff->country = $data['country'];
            $hospitalstaff->password = Hash::make($data['password']);
            $hospitalstaff->save();
            Toastr::success('Hospital Staff Created Successfully ', 'Success');
            return redirect()->route('hospitalstaff.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hospitalstaff = Hospital_Staff::find($id);
        return view('superadmin.HospitalStaff.view', compact('hospitalstaff', 'id'));
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
        $hospitalstaff = Hospital_Staff::find($id);
        return view('superadmin.HospitalStaff.create', compact('hospitalstaff', 'id'));
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
        $hospitalstaff = Hospital_Staff::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/HospitalStaff_image');
            $file->move($destinationPath, $fileName);
            $hospitalstaff->image = $fileName;
        }
        $hospitalstaff->name    = $data['name'];
        $hospitalstaff->address = $data['address'];
        $hospitalstaff->mobile  = $data['mobile'];
        $hospitalstaff->age     = $data['age'];
        $hospitalstaff->city    = $data['city'];
        $hospitalstaff->pincode = $data['pincode'];
        $hospitalstaff->country = $data['country'];
        if ($data['password'] != '') {
            $hospitalstaff->password = Hash::make($data['password']);
        }
        $hospitalstaff->save();

        Toastr::success('Hospital Staff Updated Successfully ', 'Success');
        return redirect()->route('hospitalstaff.index');
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
        Hospital_Staff::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Hospital Staff Deleted Successfully ', 'Success');
        return redirect()->route('hospitalstaff.index');
    }
}
