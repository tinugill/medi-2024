<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hospital;
use Toastr;
use Validator;
use Hash;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customer    =   User::where('is_deleted', '0')->get();

        return view('superadmin.Customer.index', compact('customer'));
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
        $customer = '';
        return view('superadmin.Customer.create', compact('id', 'customer'));
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
            'email' => 'required|unique:users,email',
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'country' => 'required'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('customer.create');
        } else {

            $customer = new User;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/customer_image');
                $file->move($destinationPath, $fileName);
                $customer->image = $fileName;
            }
            $customer->name    = $data['name'];
            $customer->email   = $data['email'];
            $customer->age   = $data['age'];
            $customer->address = $data['address'];
            $customer->mobile  = $data['mobile'];
            $customer->city    = $data['city'];
            $customer->pincode = $data['pincode'];
            $customer->country = $data['country'];
            $customer->password = Hash::make($data['password']);
            $customer->save();
            Toastr::success('Customer Created Successfully ', 'Success');
            return redirect()->route('customer.index');
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
        $customer = User::find($id);
        return view('superadmin.Customer.view', compact('customer', 'id'));
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
        $customer = User::find($id);

        return view('superadmin.Customer.create', compact('customer', 'id'));
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
        $customer = User::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/customer_image');
            $file->move($destinationPath, $fileName);
            $customer->image = $fileName;
        }
        $customer->name    = $data['name'];
        $customer->email   = $data['email'];
        $customer->age   = $data['age'];
        $customer->address = $data['address'];
        $customer->mobile  = $data['mobile'];
        $customer->city    = $data['city'];
        $customer->pincode = $data['pincode'];
        $customer->country = $data['country'];
        $customer->password = Hash::make($data['password']);
        $customer->save();
        Toastr::success('Customer Updated Successfully ', 'Success');
        return redirect()->route('customer.index');
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
        User::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Customer Deleted Successfully ', 'Success');
        return redirect()->route('customer.index');
    }
}
