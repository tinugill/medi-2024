<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Toastr;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $subcategory    =   SubCategory::with('category')->get();
        return view('superadmin.SubCategory.index', compact('subcategory'));
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
        $subcategory = '';
        $category = Category::all();
        return view('superadmin.SubCategory.create', compact('id', 'subcategory', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subcategory = new SubCategory;

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/category_image');
            $file->move($destinationPath, $fileName);
            $subcategory->image = $fileName;
        }
        $subcategory->title    = $data['title'];
        $subcategory->category_id    = $data['category_id'];
        $subcategory->description = $data['description'];
        if ($data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['title']);
        } else {
            $data['slug'] = $this->createSlug($data['slug']);
        }
        $subcategory->slug = $data['slug'];
        $subcategory->save();
        Toastr::success('SubCategory Created Successfully ', 'Success');
        return redirect()->route('subcategory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = SubCategory::find($id);
        return view('superadmin.SubCategory.view', compact('subcategory', 'id'));
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
        $subcategory = SubCategory::find($id);
        $category = Category::all();
        return view('superadmin.SubCategory.create', compact('subcategory', 'id', 'category'));
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
        $subcategory = SubCategory::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/category_image');
            $file->move($destinationPath, $fileName);
            $subcategory->image = $fileName;
        }

        $subcategory->title    = $data['title'];
        $subcategory->category_id    = $data['category_id'];
        $subcategory->description = $data['description'];
        if ($data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['title'], $id);
        } else {
            $data['slug'] = $this->createSlug($data['slug'], $id);
        }
        $subcategory->slug = $data['slug'];
        $subcategory->save();
        Toastr::success('SubCategory Updated Successfully ', 'Success');
        return redirect()->route('subcategory.index');
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
        SubCategory::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('SubCategory Deleted Successfully ', 'Success');
        return redirect()->route('subcategory.index');
    }

    public function createSlug($title, $id = 0)
    {
        $slug = Str::slug($title);
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }

        $i = 1;
        $is_contain = true;
        do {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                $is_contain = false;
                return $newSlug;
            }
            $i++;
        } while ($is_contain);
    }
    protected function getRelatedSlugs($slug, $id = 0)
    {
        return SubCategory::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
