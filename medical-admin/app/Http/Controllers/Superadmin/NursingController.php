<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nursing;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Str;
use Toastr;
use Validator;
use Hash;

class NursingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nursing    =   Nursing::where('is_deleted','0')->get();

        return view('superadmin.Nursing.index', compact('nursing'));
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
        $nursing = '';
        return view('superadmin.Nursing.create', compact('id', 'nursing', 'hospital'));
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
            'email' => 'required|email|unique:nursings,email'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('nursing.create');
        } else {

            $nursing = new Nursing;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $nursing->image = $fileName;
            }
            
            if ($request->hasFile('id_proof')) {
                $file = $request->file('id_proof');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $nursing->id_proof = $fileName;
            }
            if ($request->hasFile('registration_certificate')) {
                $file = $request->file('registration_certificate');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $nursing->registration_certificate = $fileName;
            }
            if ($request->hasFile('degree')) {
                $file = $request->file('degree');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $nursing->degree = $fileName;
            }
            $uData['name'] =  $nursing->name    = $data['name'];
            
            $nursing->regis_type    = $data['regis_type'];
            $nursing->gender    = $data['gender'];
            $nursing->type    = $data['type'];
            $nursing->part_fill_time    = $data['part_fill_time'];
            $nursing->work_hours    = $data['work_hours']; 
            $nursing->is_weekof_replacement    = $data['is_weekof_replacement']; 
            $nursing->about    = $data['about']; 
            $nursing->address    = $data['address']; 
            
            $uData['email'] = $nursing->email   = $data['email'];
            $nursing->address = $data['address'];
            $uData['mobile'] = $nursing->mobile  = $data['mobile'];
            $nursing->city    = $data['city'];
            $nursing->pincode = $data['pincode'];
            $nursing->country = $data['country'];
            if(isset($data['days'])){
                $nursing->days = json_encode($data['days']);
            }
            
            $nursing->experience = $data['experience'];
            $nursing->custom_remarks = $data['custom_remarks'];
            $nursing->visit_charges = $data['visit_charges'];
            $nursing->per_hour_charges = $data['per_hour_charges'];
            $nursing->per_month_charges = $data['per_month_charges'];
            $nursing->qualification = $data['qualification'];
            
            $nursing->latitude = $data['latitude'];
            $nursing->longitude = $data['longitude'];

           
            if(isset($data['password']) && $data['password'] != ''){
                $uData['password'] = Hash::make($data['password']);
            }
            if (@$data['slug'] == '') {
                $data['slug'] = $this->createSlug($data['name']);
            } else {
                $data['slug'] = $this->createSlug($data['slug']);
            }
            $nursing->slug = $data['slug'];

            $nursingArray = $nursing->toArray();
            $nursingArray = array_filter($nursingArray, function($value) {
                return !empty($value);
            });
            $nursing = new Nursing($nursingArray);
            $nursing->save();

            $uData['type'] = 'Nursing';
            $uData['uid'] = $nursing->id;
            $this->createUser($uData, 'create');

            Toastr::success('Nursing Created Successfully ', 'Success');
            return redirect()->route('nursing.index');
        }
    }
    function createUser($data, $type)
    {
        if ($type == 'create') {
            $user = new User();
        } else {
            $user = User::where('uid', $data['uid'])->where('type', 'Nursing')->first();
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
        $special = Nursing::find($id);
        return view('superadmin.Nursing.view', compact('special', 'id'));
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
        $nursing = Nursing::find($id);
        $hospital = Hospital::all();
        return view('superadmin.Nursing.create', compact('nursing', 'hospital', 'id'));
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
        $nursing = Nursing::find($id);

        $data = $request->all();

        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $nursing->image = $fileName;
        }
        
        if ($request->hasFile('id_proof')) {
            $file = $request->file('id_proof');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $nursing->id_proof = $fileName;
        }
        if ($request->hasFile('registration_certificate')) {
            $file = $request->file('registration_certificate');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $nursing->registration_certificate = $fileName;
        }
        if ($request->hasFile('degree')) {
            $file = $request->file('degree');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $nursing->degree = $fileName;
        }
        $uData['name'] =  $nursing->name    = $data['name'];
        
        $nursing->regis_type    = $data['regis_type'];
        $nursing->gender    = $data['gender'];
        $nursing->type    = $data['type'];
        $nursing->part_fill_time    = $data['part_fill_time'];
        $nursing->work_hours    = $data['work_hours']; 
        $nursing->is_weekof_replacement    = $data['is_weekof_replacement']; 
        $nursing->about    = $data['about']; 
        $nursing->address    = $data['address']; 
        
        $uData['email'] = $nursing->email   = $data['email'];
        $nursing->address = $data['address'];
        $uData['mobile'] = $nursing->mobile  = $data['mobile'];
        $nursing->city    = $data['city'];
        $nursing->pincode = $data['pincode'];
        $nursing->country = $data['country'];
        if(isset($data['days'])){
            $nursing->days = json_encode($data['days']);
        }
        
        $nursing->experience = $data['experience'];
        $nursing->custom_remarks = $data['custom_remarks'];
        $nursing->visit_charges = $data['visit_charges'];
        $nursing->per_hour_charges = $data['per_hour_charges'];
        $nursing->per_month_charges = $data['per_month_charges'];
        $nursing->qualification = $data['qualification'];
        
        $nursing->latitude = $data['latitude'];
        $nursing->longitude = $data['longitude'];

        if(isset($data['password']) && $data['password'] != ''){
            $uData['password'] = Hash::make($data['password']);
        }
        
        if (@$data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['name']);
        } else {
            $data['slug'] = $this->createSlug($data['slug']);
        }
        $nursing->slug = $data['slug'];
        array_walk($nursing, function ($v, $k) use ($nursing)  {
            if(empty($v)) unset($nursing->$k);
        });
        $nursing->save();

        $uData['type'] = 'Nursing';
        $uData['uid'] = $id;

        $this->createUser($uData, 'update');
        Toastr::success('Nursing Updated Successfully ', 'Success');
        return redirect()->route('nursing.index');
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
        Nursing::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Nursing Deleted Successfully ', 'Success');
        return redirect()->route('nursing.index');
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
        return Nursing::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
