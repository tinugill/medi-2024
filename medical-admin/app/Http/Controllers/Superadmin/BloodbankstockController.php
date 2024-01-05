<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bloodbankstock;
use App\Models\Hospital;
use App\Models\BloodbankComponent;
use Illuminate\Support\Str;
use Toastr;
use Validator;
use Hash;

class BloodbankstockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bid = @$_GET['bid'];
        $bloodbankstock    =   Bloodbankstock::get();
        if ($bid != '') {
            $bloodbankstock = $bloodbankstock->where('bloodbank_id', $bid);
        }

        return view('superadmin.Bloodbankstock.index', compact('bloodbankstock'));
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
        $hospital = Hospital::all();
        $BloodbankComponent = BloodbankComponent::all();
        $bloodbankstock = '';
        return view('superadmin.Bloodbankstock.create', compact('id', 'bloodbankstock', 'hospital', 'BloodbankComponent'));
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
            'component_name' => 'required',
            'email' => 'required|email|unique:pharmacists,email'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('bloodbankstock.create');
        } else {

            $bloodbankstock = new Bloodbankstock;

            $data = $request->all();

            $bloodbankstock->component_name    = $data['component_name'];
            $bloodbankstock->avialablity = $data['avialablity'];
            $bloodbankstock->available_unit = $data['available_unit'];
            $bloodbankstock->save();

            Toastr::success('Bloodbankstock Created Successfully ', 'Success');
            return redirect()->route('bloodbankstock.index');
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
        $special = Bloodbankstock::find($id);
        return view('superadmin.Bloodbankstock.view', compact('special', 'id'));
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
        $bloodbankstock = Bloodbankstock::find($id);
        $BloodbankComponent = BloodbankComponent::all();
        $hospital = Hospital::all();
        return view('superadmin.Bloodbankstock.create', compact('bloodbankstock', 'BloodbankComponent', 'hospital', 'id'));
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
        $bloodbankstock = Bloodbankstock::find($id);

        $data = $request->all();

        $bloodbankstock->component_name    = $data['component_name'];
        $bloodbankstock->avialablity = $data['avialablity'];
        $bloodbankstock->available_unit = $data['available_unit'];

        $bloodbankstock->save();

        Toastr::success('Bloodbankstock Updated Successfully ', 'Success');
        return redirect()->route('bloodbankstock.index', ['bid' => $bloodbankstock->bloodbank_id]);
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
        Bloodbankstock::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Bloodbankstock Deleted Successfully ', 'Success');
        return redirect()->route('bloodbankstock.index');
    }
}
