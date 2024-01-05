<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Category;
use App\Models\Pharmacy;
use App\Models\SubCategory;
use App\Models\Price;
use App\Models\Formulation;
use Illuminate\Support\Str;
use Toastr;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::where('is_deleted', '0')->get();
        return view('superadmin.product.index', compact('product'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $id = '';
        $product = '';
        $categories = Category::all();
        $pharmacy = Pharmacy::all();
        $Formulation = Formulation::all();
        return view('superadmin.product.create', compact('id', 'Formulation', 'product', 'categories', 'pharmacy'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $product = new Product;
        $data = $request->all();

        $product->pharmacy_id = $data['pharmacy_id'];
        $product->category_id = $data['category_id'];
        $product->sub_category_id = $data['sub_category_id'];
        $product->formulation_id = $data['formulation_id'];
        $product->avaliblity = $data['avaliblity'];
        // $product->brand_name = $data['brand_name'];
        $product->salt_name = $data['salt_name'];
        $product->expiry_month = $data['expiry_month'];
        $product->expiry_year = $data['expiry_year'];
        $product->expiry_type = $data['expiry_type'];
        $product->title = $data['title'];
        $product->avaliblity = $data['avaliblity'];
        $product->manufacturer_name = $data['manufacturer_name'];
        $product->prescription_required = $data['prescription_required'];
        $product->variant_name = $data['variant_name'];
        $product->mrp = $data['mrp'];
        $product->discount = $data['discount'];
        $product->strength = $data['strength'];
        $product->manufacturer_address =  $data['manufacturer_address'];

        // $product->benefits = $data['benefits'];
        // $product->ingredients = $data['ingredients'];
        // $product->uses = $data['uses'];
        //$product->country_of_origin = $data['country_of_origin'];
        if (@$data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['title']);
        } else {
            $data['slug'] = $this->createSlug($data['slug']);
        }
        $product->slug = $data['slug'];

        $product->description = $data['product_description'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/product_image');
            $file->move($destinationPath, $fileName);
            $product->image = $fileName;
        }
        if ($request->hasFile('image_2')) {
            $file = $request->file('image_2');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/product_image');
            $file->move($destinationPath, $fileName);
            $product->image_2 = $fileName;
        }
        if ($request->hasFile('image_3')) {
            $file = $request->file('image_3');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/product_image');
            $file->move($destinationPath, $fileName);
            $product->image_3 = $fileName;
        }
        if ($request->hasFile('image_4')) {
            $file = $request->file('image_4');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/product_image');
            $file->move($destinationPath, $fileName);
            $product->image_4 = $fileName;
        }

        $product->save();

        Toastr::success('Product Created Successfully ', 'Success');
        return redirect()->route('product.index');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product    = Product::find($id);
        $categories = Category::all()->where('is_deleted', '0');

        $subcat = SubCategory::all()->where('is_deleted', '0')->where('category_id', $product->category_id);
        $pharmacy   = Pharmacy::all();
        $Formulation   = Formulation::all();
        return view('superadmin.product.create', compact('id', 'Formulation', 'product', 'categories', 'pharmacy', 'subcat'));
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
        $product = Product::find($id);
        $data = $request->all();

        $product->pharmacy_id = $data['pharmacy_id'];
        $product->category_id = $data['category_id'];
        $product->sub_category_id = $data['sub_category_id'];
        $product->title = $data['title'];
        $product->manufacturer_name = $data['manufacturer_name'];
        $product->prescription_required = $data['prescription_required'];
        $product->variant_name = $data['variant_name'];
        $product->mrp = $data['mrp'];
        $product->discount = $data['discount'];
        $product->strength = $data['strength'];
        $product->formulation_id = $data['formulation_id'];
        $product->avaliblity = $data['avaliblity'];
        // $product->brand_name = $data['brand_name'];
        $product->salt_name = $data['salt_name'];
        $product->expiry_month = $data['expiry_month'];
      $product->expiry_year = $data['expiry_year'];
      $product->expiry_type = $data['expiry_type'];
        //$product->country_of_origin = $data['country_of_origin'];
        if (@$data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['title'], $id);
        } else {
            $data['slug'] = $this->createSlug($data['slug'], $id);
        }
        $product->slug = $data['slug'];


        // $product->benefits = $data['benefits'];
        // $product->ingredients = $data['ingredients'];
        // $product->uses = $data['uses'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/product_image');
            $file->move($destinationPath, $fileName);
            $product->image = $fileName;
        }
        if ($request->hasFile('image_2')) {
            $file = $request->file('image_2');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/product_image');
            $file->move($destinationPath, $fileName);
            $product->image_2 = $fileName;
        }
        if ($request->hasFile('image_3')) {
            $file = $request->file('image_3');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/product_image');
            $file->move($destinationPath, $fileName);
            $product->image_3 = $fileName;
        }
        if ($request->hasFile('image_4')) {
            $file = $request->file('image_4');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/product_image');
            $file->move($destinationPath, $fileName);
            $product->image_4 = $fileName;
        }

        $product->description = $data['product_description'];

        $product->save();



        Toastr::success('Product Updated Successfully ', 'Success');
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Product Deleted Successfully ', 'Success');
        return redirect()->route('product.index');
    }



    /**
     * Get Ajax Request and restun Data
     *
     * @return \Illuminate\Http\Response
     */
    public function subCategoryAjax($id)
    {
        $subcategory = SubCategory::where("category_id", $id)->get();
        return json_encode($subcategory);
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
        return Product::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
