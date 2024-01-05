<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Labtestcategory;
use Illuminate\Support\Str;
use Toastr;
use Validator;


class LabtestcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category    =   Labtestcategory::where('is_deleted', '0')->get();

        return view('superadmin.Labtestcategory.index', compact('category'));
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
        $category = '';
        return view('superadmin.Labtestcategory.create', compact('id', 'category'));
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
            'title' => 'required'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('Labtestcategory.create');
        } else {

            $category = new Labtestcategory;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/category_image');
                $file->move($destinationPath, $fileName);
                $category->image = $fileName;
            }
            $category->title    = $data['title'];
            $category->save();
            Toastr::success('Lab Test Category Created Successfully ', 'Success');
            return redirect()->route('labtestcategory.index');
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
        return view('superadmin.Labtestcategory.view', compact('category', 'id'));
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
        $category = Labtestcategory::find($id);

        return view('superadmin.Labtestcategory.create', compact('category', 'id'));
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
        $category = Labtestcategory::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/category_image');
            $file->move($destinationPath, $fileName);
            $category->image = $fileName;
        }
        $category->title    = $data['title'];

        $category->save();
        Toastr::success('Lab Test Category Updated Successfully ', 'Success');
        return redirect()->route('labtestcategory.index');
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
        Labtestcategory::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Lab Test Category Deleted Successfully ', 'Success');
        return redirect()->route('labtestcategory.index');
    }
}
