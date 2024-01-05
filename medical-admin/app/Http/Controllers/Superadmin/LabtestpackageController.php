<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Labtestcategory;
use App\Models\Laboratorist;
use App\Models\Labtest;
use App\Models\Labtestpackage;
use Illuminate\Support\Str;
use Toastr;
use Validator;

use function GuzzleHttp\json_encode;

class LabtestpackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category    =   Labtestpackage::where('is_deleted', '0')->get();

        return view('superadmin.Labtestpackage.index', compact('category'));
    }

    public function labTestAjax($id)
    {
        $labtestlist = Labtest::where("lab_id", $id)->get();
        return json_encode($labtestlist);
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
        $Labtestpackage = '';
        $labtest = Labtest::all();
        $labs = Laboratorist::all();
        return view('superadmin.Labtestpackage.create', compact('id', 'labtest', 'Labtestpackage', 'labs'));
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
            'package_name' => 'required',
            'price' => 'required'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('labtestpackage.create');
        } else {

            $category = new Labtestpackage;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/laboratorist_image');
                $file->move($destinationPath, $fileName);
                $category->image = $fileName;
            }
            $category->lab_id    = $data['lab_id'];
            $category->test_ids    = json_encode($data['test_ids']);
            $category->package_name    = $data['package_name'];
            $category->price    = $data['price'];
            $category->discount    = $data['discount'];
            $category->home_sample_collection    = $data['home_sample_collection'];
            $category->report_home_delivery    = $data['report_home_delivery'];
            $category->ambulance_available    = $data['ambulance_available'];
            $category->save();
            Toastr::success('Lab Test Category Created Successfully ', 'Success');
            return redirect()->route('labtestpackage.index');
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
        $category = Labtestpackage::find($id);
        return view('superadmin.Labtestpackage.view', compact('category', 'id'));
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
        $category = Labtestcategory::all();
        $Labtestpackage = Labtestpackage::find($id);
        $labtest = Labtest::find($Labtestpackage->lab_id)->get();
        $labs = Laboratorist::all();
        return view('superadmin.Labtestpackage.create', compact('category', 'id', 'labtest', 'Labtestpackage', 'labs'));
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
        $category = Labtestpackage::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/laboratorist_image');
            $file->move($destinationPath, $fileName);
            $category->image = $fileName;
        }
        $category->lab_id    = $data['lab_id'];
        $category->test_ids    = json_encode($data['test_ids']);
        $category->package_name    = $data['package_name'];
        $category->price    = $data['price'];
        $category->discount    = $data['discount'];
        $category->home_sample_collection    = $data['home_sample_collection'];
        $category->report_home_delivery    = $data['report_home_delivery'];
        $category->ambulance_available    = $data['ambulance_available'];

        $category->save();
        Toastr::success('Lab Test package Updated Successfully ', 'Success');
        return redirect()->route('labtestpackage.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Labtestpackage::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Lab Test package Deleted Successfully ', 'Success');
        return redirect()->route('labtestpackage.index');
    }
}
