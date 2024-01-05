<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Labtestcategory;
use App\Models\Laboratorist;
use App\Models\Labtest;
use Illuminate\Support\Str;
use Toastr;
use Validator;


class LabtestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category    =   Labtest::where('is_deleted', '0')->get();

        return view('superadmin.Labtest.index', compact('category'));
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
        $labtest = '';
        $category = Labtestcategory::all();
        $labs = Laboratorist::all();
        return view('superadmin.Labtest.create', compact('id', 'category', 'labtest', 'labs'));
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
            'image' => 'required|image|mimes:png,jpeg,jpg,svg,webp',
            'test_name' => 'required'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('labtest.create');
        } else {

            $category = new Labtest;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/laboratorist_image');
                $file->move($destinationPath, $fileName);
                $category->image = $fileName;
            }
            $category->lab_id    = $data['lab_id'];
            $category->category_id    = $data['category_id'];
            $category->test_name    = $data['test_name'];
            $category->price    = $data['price'];
            $category->discount    = $data['discount'];
            $category->prerequisite    = $data['prerequisite'];
            $category->home_sample_collection    = $data['home_sample_collection'];
            $category->report_home_delivery    = $data['report_home_delivery'];
            $category->ambulance_available    = $data['ambulance_available'];
            $category->is_approved    = $data['is_approved'];
            $category->save();
            Toastr::success('Lab Test Category Created Successfully ', 'Success');
            return redirect()->route('labtest.index');
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
        $category = Labtestcategory::find($id);
        return view('superadmin.Labtest.view', compact('category', 'id'));
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
        $labtest = Labtest::find($id);
        $labs = Laboratorist::all();
        return view('superadmin.Labtest.create', compact('category', 'id', 'labtest', 'labs'));
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
        $category = Labtest::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/laboratorist_image');
            $file->move($destinationPath, $fileName);
            $category->image = $fileName;
        }
        $category->lab_id    = $data['lab_id'];
        $category->category_id    = $data['category_id'];
        $category->test_name    = $data['test_name'];
        $category->price    = $data['price'];
        $category->discount    = $data['discount'];
        $category->prerequisite    = $data['prerequisite'];
        $category->home_sample_collection    = $data['home_sample_collection'];
        $category->report_home_delivery    = $data['report_home_delivery'];
        $category->ambulance_available    = $data['ambulance_available'];
        $category->is_approved    = $data['is_approved'];

        $category->save();
        Toastr::success('Lab Test Category Updated Successfully ', 'Success');
        return redirect()->route('labtest.index');
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
        Labtest::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Lab Test Category Deleted Successfully ', 'Success');
        return redirect()->route('labtest.index');
    }
}
