<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Toastr;
use Validator;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category    =   Category::where('is_deleted', '0')->get();

        return view('superadmin.Category.index', compact('category'));
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
        return view('superadmin.Category.create', compact('id', 'category'));
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
            'title' => 'required'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('category.create');
        } else {

            $category = new Category;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/category_image');
                $file->move($destinationPath, $fileName);
                $category->image = $fileName;
            }
            $category->title    = $data['title'];
            if(isset($data['description']) && $data['description'] != ''){
                $category->description = $data['description'];
            }
           
            if (@$data['slug'] == '') {
                $data['slug'] = $this->createSlug($data['title']);
            } else {
                $data['slug'] = $this->createSlug($data['slug']);
            }
            $category->slug = $data['slug'];
            $category->save();
            Toastr::success('Category Created Successfully ', 'Success');
            return redirect()->route('category.index');
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
        $category = Category::find($id);
        return view('superadmin.Category.view', compact('category', 'id'));
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
        $category = Category::find($id);

        return view('superadmin.Category.create', compact('category', 'id'));
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
        $category = Category::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/category_image');
            $file->move($destinationPath, $fileName);
            $category->image = $fileName;
        }
        $category->title    = $data['title'];
        if(isset($data['description']) && $data['description'] != ''){
            $category->description = $data['description'];
        }
        if (@$data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['title']);
        } else {
            $data['slug'] = $this->createSlug($data['slug']);
        }
        $category->slug = $data['slug'];
        $category->save();
        Toastr::success('Category Updated Successfully ', 'Success');
        return redirect()->route('category.index');
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
        Category::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Category Deleted Successfully ', 'Success');
        return redirect()->route('category.index');
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
        return Category::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
