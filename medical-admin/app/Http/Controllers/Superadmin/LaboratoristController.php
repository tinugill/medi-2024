<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laboratorist;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Str;
use Toastr;
use Validator;
use Hash;

class LaboratoristController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $laboratorist    =   Laboratorist::where('is_deleted','0')->get();

        return view('superadmin.Laboratorist.index', compact('laboratorist'));
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
        $laboratorist = '';
        return view('superadmin.Laboratorist.create', compact('id', 'laboratorist', 'hospital'));
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
            'name' => 'required',
            'email' => 'required|email|unique:pharmacists,email'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('laboratorist.create');
        } else {

            $laboratorist = new Laboratorist;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/laboratorist_image');
                $file->move($destinationPath, $fileName);
                $laboratorist->image = $fileName;
            }
            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/laboratorist_image');
                $file->move($destinationPath, $fileName);
                $laboratorist->banner_image = $fileName;
            }
            if ($request->hasFile('owner_id')) {
                $file = $request->file('owner_id');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/laboratorist_image');
                $file->move($destinationPath, $fileName);
                $laboratorist->owner_id = $fileName;
            }
            $laboratorist->name    = $data['name'];
            $laboratorist->owner_name    = $data['owner_name'];
            $laboratorist->phone_no    = $data['phone_no'];
            $laboratorist->h_c_fee    = $data['h_c_fee'];
            $laboratorist->h_c_fee_apply_before    = $data['h_c_fee_apply_before'];
            $laboratorist->r_d_fee    = $data['r_d_fee'];
            $laboratorist->r_d_fee_apply_before    = $data['r_d_fee_apply_before'];
            $laboratorist->ambulance_fee    = $data['ambulance_fee'];
            $uData['name'] = $laboratorist->cp_name    = $data['cp_name'];
            if($uData['name'] == ''){
                $uData['name'] = $data['name'];
            }
            if (isset($data['hospital_id']) && $data['hospital_id'] != '') {
                $laboratorist->hospital_id = $data['hospital_id'];
            }

            $uData['email'] = $laboratorist->email   = $data['email'];
            $laboratorist->address = $data['address'];
            $uData['mobile'] = $laboratorist->mobile  = $data['mobile'];
            $laboratorist->city    = $data['city'];
            $laboratorist->pincode = $data['pincode'];
            $laboratorist->country = $data['country'];
            if(isset($data['days'])){
                $laboratorist->days = json_encode($data['days']);
            }
            $laboratorist->about = $data['about'];
            $laboratorist->registration_detail = $data['registration_detail'];
            if ($request->hasFile('registration_file')) {
                $file = $request->file('registration_file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/laboratorist_image');
                $file->move($destinationPath, $fileName);
                $laboratorist->registration_file = $fileName;
            }
           
            $laboratorist->latitude = $data['latitude'];
            $laboratorist->longitude = $data['longitude'];

            $uData['password'] = $laboratorist->password = Hash::make($data['password']);

            if (@$data['slug'] == '') {
                $data['slug'] = $this->createSlug($data['name']);
            } else {
                $data['slug'] = $this->createSlug($data['slug']);
            }
            $laboratorist->slug = $data['slug'];

            $laboratoristArray = $laboratorist->toArray();
            $laboratoristArray = array_filter($laboratoristArray, function($value) {
                return !empty($value);
            });
            $laboratorist = new Laboratorist($laboratoristArray);
            $laboratorist->save();

            $uData['type'] = 'Lab';
            $uData['uid'] = $laboratorist->id;
            $this->createUser($uData, 'create');

            Toastr::success('Laboratorist Created Successfully ', 'Success');
            return redirect()->route('laboratorist.index');
        }
    }
    function createUser($data, $type)
    {
        if ($type == 'create') {
            $user = new User();
        } else {
            $user = User::where('uid', $data['uid'])->where('type', 'Lab')->first();
        }

        $user->uid = $data['uid'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        if (@$data['password'] != '') {
            $user->password = $data['password'];
        }

        $user->type = $data['type'];
        $user->is_verified = '0';
        $user->save();
        return $user->id;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $special = Laboratorist::find($id);
        return view('superadmin.Laboratorist.view', compact('special', 'id'));
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
        $laboratorist = Laboratorist::find($id);
        $hospital = Hospital::all();
        return view('superadmin.Laboratorist.create', compact('laboratorist', 'hospital', 'id'));
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
        $laboratorist = Laboratorist::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/laboratorist_image');
            $file->move($destinationPath, $fileName);
            $laboratorist->image = $fileName;
        }
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/laboratorist_image');
            $file->move($destinationPath, $fileName);
            $laboratorist->banner_image = $fileName;
        }
        $uData['name'] = $laboratorist->cp_name    = $data['cp_name'];
        if($uData['name'] == ''){
            $uData['name'] = $data['name'];
        }
        if ($request->hasFile('owner_id')) {
            $file = $request->file('owner_id');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/laboratorist_image');
            $file->move($destinationPath, $fileName);
            $laboratorist->owner_id = $fileName;
        }
        $laboratorist->name    = $data['name'];
        $laboratorist->owner_name    = $data['owner_name'];
        $laboratorist->phone_no    = $data['phone_no'];
        $laboratorist->h_c_fee    = $data['h_c_fee'];
        $laboratorist->h_c_fee_apply_before    = $data['h_c_fee_apply_before'];
        $laboratorist->r_d_fee    = $data['r_d_fee'];
        $laboratorist->r_d_fee_apply_before    = $data['r_d_fee_apply_before'];
        $laboratorist->ambulance_fee    = $data['ambulance_fee'];

        if (isset($data['hospital_id']) && $data['hospital_id'] != '') {
            $laboratorist->hospital_id = $data['hospital_id'];
        }
        $uData['email'] = $laboratorist->email   = $data['email'];
        $laboratorist->address = $data['address'];
        $uData['mobile'] = $laboratorist->mobile  = $data['mobile'];
        $laboratorist->city    = $data['city'];
        if(isset($data['days'])){
            $laboratorist->days = json_encode($data['days']);
        }
        
        $laboratorist->about = $data['about'];
        $laboratorist->registration_detail = $data['registration_detail'];
        if ($request->hasFile('registration_file')) {
            $file = $request->file('registration_file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/laboratorist_image');
            $file->move($destinationPath, $fileName);
            $laboratorist->registration_file = $fileName;
        }
        

        $laboratorist->pincode = $data['pincode'];
        $laboratorist->country = $data['country'];
        $laboratorist->latitude = $data['latitude'];
        $laboratorist->longitude = $data['longitude'];
        if ($data['password'] != '') {
            $uData['password'] = $laboratorist->password = Hash::make($data['password']);
        }

        if (@$data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['name'], $id);
        } else {
            $data['slug'] = $this->createSlug($data['slug'], $id);
        }
        $laboratorist->slug = $data['slug'];
        array_walk($laboratorist, function ($v, $k) use ($laboratorist)  {
            if(empty($v)) unset($laboratorist->$k);
        });
        $laboratorist->save();

        $uData['type'] = 'Lab';
        $uData['uid'] = $id;

        $this->createUser($uData, 'update');
        Toastr::success('Laboratorist Updated Successfully ', 'Success');
        return redirect()->route('laboratorist.index');
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
        Laboratorist::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Laboratorist Deleted Successfully ', 'Success');
        return redirect()->route('laboratorist.index');
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
        return Laboratorist::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
