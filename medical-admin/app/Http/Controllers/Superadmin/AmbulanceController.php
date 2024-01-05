<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ambulance;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Str;
use Toastr;
use Validator;
use Hash;

class AmbulanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ambulance    =   Ambulance::where('is_deleted','0')->get();

        return view('superadmin.Ambulance.index', compact('ambulance'));
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
        $ambulance = '';
        return view('superadmin.Ambulance.create', compact('id', 'ambulance', 'hospital'));
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
            'email' => 'required|email|unique:ambulances,email'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('ambulance.create');
        } else {

            $ambulance = new Ambulance;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $ambulance->image = $fileName;
            }
            
            if ($request->hasFile('aadhar')) {
                $file = $request->file('aadhar');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $ambulance->aadhar = $fileName;
            }
            if ($request->hasFile('registration_certificate')) {
                $file = $request->file('registration_certificate');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $ambulance->registration_certificate = $fileName;
            }
            if ($request->hasFile('gstin_proof')) {
                $file = $request->file('gstin_proof');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $ambulance->gstin_proof = $fileName;
            }
            $uData['name'] =  $ambulance->name    = $data['name'];
            
            $ambulance->public_number    = $data['public_number'];
            $ambulance->owner_name    = $data['owner_name'];
            $ambulance->type_of_user    = $data['type_of_user'];
            $ambulance->about    = $data['about'];
            $ambulance->gstin    = $data['gstin']; 
            
            $ambulance->about    = $data['about']; 
            $ambulance->address    = $data['address']; 
            
            $uData['email'] = $ambulance->email   = $data['email'];
            $ambulance->address = $data['address'];
            $uData['mobile'] = $ambulance->mobile  = $data['mobile'];
            $ambulance->city    = $data['city'];
            $ambulance->pincode = $data['pincode'];
            $ambulance->country = $data['country'];
              
            $ambulance->latitude = $data['latitude'];
            $ambulance->longitude = $data['longitude'];

           
            if(isset($data['password']) && $data['password'] != ''){
                $uData['password'] = Hash::make($data['password']);
            }
            if (@$data['slug'] == '') {
                $data['slug'] = $this->createSlug($data['name']);
            } else {
                $data['slug'] = $this->createSlug($data['slug']);
            }
            $ambulance->slug = $data['slug'];

            $ambulanceArray = $ambulance->toArray();
            $ambulanceArray = array_filter($ambulanceArray, function($value) {
                return !empty($value);
            });
            $ambulance = new Ambulance($ambulanceArray);
            $ambulance->save();

            $uData['type'] = 'Ambulance';
            $uData['uid'] = $ambulance->id;
            $this->createUser($uData, 'create');

            Toastr::success('Ambulance Created Successfully ', 'Success');
            return redirect()->route('ambulance.index');
        }
    }
    function createUser($data, $type)
    {
        if ($type == 'create') {
            $user = new User();
        } else {
            $user = User::where('uid', $data['uid'])->where('type', 'Ambulance')->first();
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
        $special = Ambulance::find($id);
        return view('superadmin.Ambulance.view', compact('special', 'id'));
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
        $ambulance = Ambulance::find($id);
        $hospital = Hospital::all();
        return view('superadmin.Ambulance.create', compact('ambulance', 'hospital', 'id'));
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
        $ambulance = Ambulance::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $ambulance->image = $fileName;
        }
        
        if ($request->hasFile('aadhar')) {
            $file = $request->file('aadhar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $ambulance->aadhar = $fileName;
        }
        if ($request->hasFile('registration_certificate')) {
            $file = $request->file('registration_certificate');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $ambulance->registration_certificate = $fileName;
        }
        if ($request->hasFile('gstin_proof')) {
            $file = $request->file('gstin_proof');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $ambulance->gstin_proof = $fileName;
        }
        $uData['name'] =  $ambulance->name    = $data['name'];
        
        $ambulance->public_number    = $data['public_number'];
        $ambulance->owner_name    = $data['owner_name'];
        $ambulance->type_of_user    = $data['type_of_user'];
        $ambulance->about    = $data['about'];
        $ambulance->gstin    = $data['gstin']; 
        
        $ambulance->about    = $data['about']; 
        $ambulance->address    = $data['address']; 
        
        $uData['email'] = $ambulance->email   = $data['email'];
        $ambulance->address = $data['address'];
        $uData['mobile'] = $ambulance->mobile  = $data['mobile'];
        $ambulance->city    = $data['city'];
        $ambulance->pincode = $data['pincode'];
        $ambulance->country = $data['country'];
          
        $ambulance->latitude = $data['latitude'];
        $ambulance->longitude = $data['longitude'];

       
        if(isset($data['password']) && $data['password'] != ''){
            $uData['password'] = Hash::make($data['password']);
        }
        if (@$data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['name']);
        } else {
            $data['slug'] = $this->createSlug($data['slug']);
        }
        $ambulance->slug = $data['slug'];
        array_walk($ambulance, function ($v, $k) use ($ambulance)  {
            if(empty($v)) unset($ambulance->$k);
        });
        $ambulance->save();

        $uData['type'] = 'Ambulance';
        $uData['uid'] = $id;

        $this->createUser($uData, 'update');
        Toastr::success('Ambulance Updated Successfully ', 'Success');
        return redirect()->route('ambulance.index');
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
        Ambulance::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Ambulance Deleted Successfully ', 'Success');
        return redirect()->route('ambulance.index');
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
        return Ambulance::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
