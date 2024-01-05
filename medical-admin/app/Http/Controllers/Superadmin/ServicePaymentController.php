<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServicePayment;
use Illuminate\Support\Str;
use Toastr;
use Validator;


class ServicePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category    =   ServicePayment::get();

        return view('superadmin.ServicePayment.index', compact('category'));
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
        return view('superadmin.ServicePayment.create', compact('id', 'category'));
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
            'title' => 'required',
            'price' => 'required',
            'discount' => 'required'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('service_payment.create');
        } else {

            $category = new ServicePayment;

            $data = $request->all();

        
            $category->title    = $data['title'];
            $category->price = $data['price'];
            $category->discount = $data['discount'];
            $category->price_4 = $data['price_4'];
            $category->discount_4 = $data['discount_4'];
            $category->price_6 = $data['price_6'];
            $category->discount_6 = $data['discount_6'];
            $category->price_12 = $data['price_12'];
            $category->discount_12 = $data['discount_12'];
            
            $category->save();
            Toastr::success('Listing Price Created Successfully ', 'Success');
            return redirect()->route('service_payment.index');
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
        $category = ServicePayment::find($id);
        return view('superadmin.ServicePayment.view', compact('category', 'id'));
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
        $category = ServicePayment::find($id);

        return view('superadmin.ServicePayment.create', compact('category', 'id'));
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
        $category = ServicePayment::find($id);

        $data = $request->all();
        $category->title    = $data['title'];
        $category->price = $data['price'];
        $category->discount = $data['discount'];
        $category->price_4 = $data['price_4'];
        $category->discount_4 = $data['discount_4'];
        $category->price_6 = $data['price_6'];
        $category->discount_6 = $data['discount_6'];
        $category->price_12 = $data['price_12'];
        $category->discount_12 = $data['discount_12'];
        
        $category->save();
        Toastr::success('Listing details Updated Successfully ', 'Success');
        return redirect()->route('service_payment.index');
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
        ServicePayment::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Listing price Deleted Successfully ', 'Success');
        return redirect()->route('service_payment.index');
    }
    
}
