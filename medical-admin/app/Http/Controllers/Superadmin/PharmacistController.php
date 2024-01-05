<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pharmacist;
use App\Models\Hospital;
use Toastr;
use Validator;
use Hash;


class PharmacistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pharmacist    =   Pharmacist::with('hospital')->get();

        return view('superadmin.Pharmacist.index',compact('pharmacist'));
         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $id='';
        $hospital = Hospital::all();
        $Pharmacist = '';
        return view('superadmin.Pharmacist.create',compact('id','Pharmacist','hospital'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'image'=> 'required|image|mimes:png,jpeg,jpg',
                'banner_image'=> 'required|image|mimes:png,jpeg,jpg',
                'name'=>'required',
                'email'=>'required|email|unique:pharmacists,email'
            ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('pharmacist.create');
        }else{

            $pharmacist = new Pharmacist;

            $data = $request->all();
            
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('/pharmacist_image');
                $file->move($destinationPath, $fileName);
                $pharmacist->image = $fileName;
            }
            if($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $fileName = time() . '.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('/pharmacist_image');
                $file->move($destinationPath, $fileName);
                $pharmacist->banner_image = $fileName;
            }
            $pharmacist->name    = $data['name'];
            $pharmacist->hospital_id = $data['hospital_id'];
            $pharmacist->email   = $data['email'];
            $pharmacist->address = $data['address'];
            $pharmacist->mobile  = $data['mobile'];
            $pharmacist->city    = $data['city'];
            $pharmacist->pincode = $data['pincode'];
            $pharmacist->country = $data['country'];
            $pharmacist->latitude = $data['latitude'];
            $pharmacist->longitude = $data['longitude'];
            $pharmacist->password= Hash::make($data['password']); 
            $pharmacist->save();
        
        Toastr::success('Pharmacist Created Successfully ','Success');
        return redirect()->route('pharmacist.index');
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
       $special= Pharmacist::find($id);
       return view('superadmin.Pharmacist.view',compact('special','id'));
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
        $pharmacist = Pharmacist::find($id);
        $hospital = Hospital::all();
        return view('superadmin.Pharmacist.create',compact('pharmacist','hospital','id'));
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
        $pharmacist = Pharmacist::find($id);

        $data = $request->all();
        
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/pharmacist_image');
            $file->move($destinationPath, $fileName);
            $pharmacist->image = $fileName;
        }
        if($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $fileName = time() . '.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/pharmacist_image');
            $file->move($destinationPath, $fileName);
            $pharmacist->banner_image = $fileName;
        }
        $pharmacist->name    = $data['name'];
        $pharmacist->hospital_id = $data['hospital_id'];
        $pharmacist->email   = $data['email'];
        $pharmacist->address = $data['address'];
        $pharmacist->mobile  = $data['mobile'];
        $pharmacist->city    = $data['city'];
        $pharmacist->pincode = $data['pincode'];
        $pharmacist->country = $data['country'];
        $pharmacist->latitude = $data['latitude'];
        $pharmacist->longitude = $data['longitude'];
        $pharmacist->password = Hash::make($data['password']); 
        $pharmacist->save();
        Toastr::success('Pharmacist Updated Successfully ','Success');
        return redirect()->route('pharmacist.index');
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
        Pharmacist::where('id',$id)->update(['is_deleted'=>'1']);
        Toastr::success('Pharmacist Deleted Successfully ','Success');
        return redirect()->route('pharmacist.index');
    }
}
