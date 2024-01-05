<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Formulation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Price;
use App\Models\Product;
use App\Models\Pharmacy;
use App\Models\Product_image;
use DB;
use Auth;

class ProductController extends Controller
{
  public function getDealerEqpCategory(Request $request)
  {
    $cat = DB::table('category_eqps')->where('is_deleted', '0')->orderBy('title')->get();
    return successResponse('List', $cat, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getCategory(Request $request)
  {
    $cat = DB::table('categories')->where('is_deleted', '0')->orderBy('title')->get();
    return successResponse('List', $cat, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getFormulation(Request $request)
  {
    $cat = DB::table('formulations')->orderBy('title')->get();
    return successResponse('List', $cat, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getComposition(Request $request)
  {
    $cat = DB::table('compositions')->orderBy('title')->get();
    return successResponse('List', $cat, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getCategoryWithProduct(Request $request)
  {
    $cat = DB::table('categories')->where('is_deleted', '0')->get();
    $sendArray = array();
    for ($j = 0; $j < count($cat); $j++) {
      $product = DB::table('products')->where('category_id', $cat[$j]->id)->where('is_deleted', '0')->limit(10)->get();

      $cat[$j]->products = $product;
    }
    return successResponse('List', $cat, \Config::get('constants.status_code.SUCCESS'));
  }
  public function getSubCategory(Request $request)
  {
    $subcat = DB::table('sub_categories')->where('is_deleted', '0');
    if($request->category_id != ''){
      if (!is_numeric($request->category_id)) {
        $cat = DB::table('categories')->where('slug', $request->category_id)->where('is_deleted', '0')->first();
        $subcat->where('category_id', $cat->id);
      } else {
        $subcat->where('category_id', $request->category_id);
      }
    }
    
    $subcat = $subcat->orderBy('title')->get();
    return successResponse('List', $subcat, \Config::get('constants.status_code.SUCCESS'));
  }

  public function getProducts(Request $request)
  { 
    $product = DB::table('products')->leftJoin('formulations', 'formulations.id', '=', 'products.formulation_id')
    ->select('products.*', 'formulations.title as formulation_name')->where('products.is_deleted', '0')->where('products.avaliblity','Yes')->limit(20);
    if (isset($request->only_id) && $request->only_id != '') {
      $product->where('pharmacy_id', $request->only_id);
    }
    if (isset($request->category_id) && $request->category_id != '') {
      if (!is_numeric($request->category_id)) {
        $cat = DB::table('categories')->where('slug', $request->category_id)->where('is_deleted', '0')->first();
        $product->where('category_id', $cat->id);
      } else {
        $product->where('category_id', $request->category_id);
      }
    }
    if (isset($request->salt_name) && $request->salt_name != '') {
      if (is_numeric($request->salt_name)) {
        $product->where('salt_name', $request->salt_name);
      }else{
        $cat = DB::table('compositions')->where('title', $request->salt_name)->where('is_deleted', '0')->first();
        if($cat){
          $product->where('salt_name', $cat->id);
        }else{
          $product->where('salt_name', ''); //to not show if composition not exist
        }
        
      }
    }
    if (isset($request->sub_cat) && $request->sub_cat != '') {
      $subCat = json_decode($request->sub_cat, true);
      if($subCat != ''){
        if (count($subCat) > 0) {
          $product->whereIn('sub_category_id', $subCat);
        }
      } 
    }

    if($request->q != ''){
      $product->where('products.title',  'like', '%' . $request->q . '%');
    }

    if (isset($request->id) && $request->id != '') {
      $product->where('products.id', $request->id);
      $product = $product->first();
    } else if (isset($request->slug) && $request->slug != '') {
      $product->where('slug', $request->slug);
      $product = $product->first();

      if(!empty($product)){
        $salt = DB::table('compositions')->where('id', $product->salt_name)->where('is_deleted', '0')->first();
        if(!empty($salt)){
          $product->salt_name = $salt->title;
        }
      } 

      $product->image = asset('product_image/' . $product->image);
      if($product->image_2 != ''){
        $product->image_2 = asset('product_image/' . $product->image_2);
      }else{
        unset($product->image_2);
      }
      if($product->image_3 != ''){
        $product->image_3 = asset('product_image/' . $product->image_3);
      }else{
        unset($product->image_3);
      }
      if($product->image_4 != ''){
        $product->image_4 = asset('product_image/' . $product->image_4); 
      }else{
        unset($product->image_4);
      }
      if(!empty($product)){
        $f = Formulation::find($product->formulation_id);
        if(!empty($f)){
          $product->formulation = $f->title; 
        }else{
          $product->formulation = ''; 
        } 
      }

    } else {
      if(isset($request->limit) && $request->limit != ''){
        $product->limit($request->limit);
      }
      $product = $product->get();
    }


    return successResponse('List', $product, \Config::get('constants.status_code.SUCCESS'));
  }

  function uploadBase64File($fileSource, $type = '', $folder)
  {
    $image_source = explode(";base64,", $fileSource);
    if ($type == '') {
      $image_type_aux = explode("image/", $image_source[0]);
      $image_type = @$image_type_aux[1];
    } else if ($type == 'pdf') {
      $image_type = 'pdf';
    }

    $png_url = "p-" . rand(1000, 100000) . time() . "." . $image_type;
    $path = public_path() . '/' . $folder . '/' . $png_url;

    $base_decode64 = base64_decode(str_replace(' ', '+', $image_source[1]));
    if (file_put_contents($path, $base_decode64)) {
      return array('status' => true, 'file_name' => $png_url, 'type' => $image_type);
    } else {
      return array('status' => false, 'file_name' => 'Error', 'type' => '');
    }
  }

  public function addMyProducts(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      if ($request->id == '' || $request->id == 'null') {
        $product = new Product;
      } else {
        $product = Product::find($request->id);
      }

      $data = $request->all();
      $p = Pharmacy::find($user->uid);
      
      if($request->copy_from != ''){
        $cpyFrom = Product::find($request->copy_from);
        $product->image = $cpyFrom->image;
        $product->image_2 =  $cpyFrom->image_2;
        $product->image_3 =  $cpyFrom->image_3;
        $product->image_4 =  $cpyFrom->image_4;
      }

      
      $product->pharmacy_id = $p->id;
      $product->productType = $data['productType'];
      $product->category_id = $data['category_id'];
      // $product->sub_category_id = $data['sub_category_id'];
      $product->formulation_id = $data['formulation_id'];
      $product->avaliblity = $data['avaliblity'];
      if ($data['brand_name'] != '' && $data['brand_name'] != 'null') {
        $product->brand_name = $data['brand_name'];
      }
      if($data['salt_name'] != ''){
      $product->salt_name = $data['salt_name'];
      }
      if($data['expiry_month'] != ''){
        $product->expiry_month = $data['expiry_month'];
      }
      if($data['expiry_year'] != ''){
        $product->expiry_year = $data['expiry_year'];
      }
      if($data['expiry_type'] != ''){
        $product->expiry_type = $data['expiry_type'];
      }
      
      $product->variant_name = $data['variant_name'];
      $product->mrp = $data['mrp'];
      $product->discount = $data['discount'];
      $product->strength = $data['strength'];
      $product->title = $data['title'];
      $product->prescription_required = $data['prescription_required'];
      $product->manufacturer_name = $data['manufacturer_name'];
      $product->manufacturer_address =  $data['manufacturer_address'];

      // $product->benefits = $data['benefits'];
      // $product->ingredients = $data['ingredients'];
      // $product->uses = $data['uses'];
      $product->description = $data['description'];
      //$product->country_of_origin = $data['country_of_origin'];

      $data['slug'] = $this->createSlug($data['title']);

      if ($data['image'] != '' && $data['image'] != 'null') {
        $image = uploadBase64File($data['image'], '', 'product_image');
        if ($image['status']) {
          $product->image = $image['file_name'];
        }
      }
      if ($data['image_2'] != '' && $data['image_2'] != 'null') {
        $image = uploadBase64File($data['image_2'], '', 'product_image');
        if ($image['status']) {
          $product->image_2 = $image['file_name'];
        }
      }
      if ($data['image_3'] != '' && $data['image_3'] != 'null') {
        $image = uploadBase64File($data['image_3'], '', 'product_image');
        if ($image['status']) {
          $product->image_3 = $image['file_name'];
        }
      }
      if ($data['image_4'] != '' && $data['image_4'] != 'null') {
        $image = uploadBase64File($data['image_4'], '', 'product_image');
        if ($image['status']) {
          $product->image_4 = $image['file_name'];
        }
      }

      $product->slug = $data['slug'];
      $product->save();

      return successResponse('Product updated', $product, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
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
  public function searchMyProducts(Request $request)
  { 
    $product = DB::table('products')->where('is_deleted', '0');
    $product->where('productType','medicine')->where('title',  'like', '%' . $request->title . '%');
    $product = $product->orderBy('id', 'desc')->limit(4)->get(); 
    
    return successResponse('List', $product, \Config::get('constants.status_code.SUCCESS'));
  
  }
  public function getMyProducts(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $product = DB::table('products')->where('pharmacy_id', $user->uid)->where('is_deleted', '0');

      if (isset($request->id) && $request->id != '') {
        $product->where('id', $request->id);
        $product = $product->first(); 
        $product->pricelist = DB::table('prices')->where('product_id', $product->id)->get();
      } else {
        if (isset($request->productType) && $request->productType != '') {
          $product->where('productType',$request->productType);
        }
        $product = $product->get(); 
      }
      return successResponse('List', $product, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function getMediProducts(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $search = $request->search;
      $product = DB::table('products')
      ->where(function($query) use ($search){
        $query->where('title', 'like', '%' . $search . '%')
        ->orWhere('variant_name', 'like', '%' . $search . '%');
      })
      // ->where('pharmacy_id','!=', $user->uid)
      ->where('productType', $request->productType)
      ->where('is_deleted', '0')
      ->limit(100);
 
      $product = $product->get();
      for ($i = 0; $i < count($product); $i++) { 
        $product[$i]->pricelist = DB::table('prices')->where('product_id', $product[$i]->id)->get();
     
      } 
      return successResponse('List', $product, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
}
