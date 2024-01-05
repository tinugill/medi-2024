<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Str;
use Toastr;
use Validator;
use Hash;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dealer    =   Dealer::where('is_deleted','0')->get();

        return view('superadmin.Dealer.index', compact('dealer'));
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
        $dealer = '';
        return view('superadmin.Dealer.create', compact('id', 'dealer', 'hospital'));
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
            'email' => 'required|email|unique:dealers,email'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('dealer.create');
        } else {

            $dealer = new Dealer;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $dealer->image = $fileName;
            }
            
            if ($request->hasFile('owner_id')) {
                $file = $request->file('owner_id');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $dealer->owner_id = $fileName;
            }
            
            if ($request->hasFile('partner_id')) {
                $file = $request->file('partner_id');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $dealer->partner_id = $fileName;
            }
            if ($request->hasFile('registration_certificate')) {
                $file = $request->file('registration_certificate');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $dealer->registration_certificate = $fileName;
            }
            if ($request->hasFile('gstin_proof')) {
                $file = $request->file('gstin_proof');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $dealer->gstin_proof = $fileName;
            }
            $uData['name'] =  $dealer->name    = $data['name'];
            
            $dealer->partner_name    = $data['partner_name'];
            $dealer->owner_name    = $data['owner_name']; 
            $dealer->about    = $data['about'];
            $dealer->gstin    = $data['gstin']; 
            
            $dealer->about    = $data['about']; 
            $dealer->address    = $data['address']; 
            
            $uData['email'] = $dealer->email   = $data['email'];
            $dealer->address = $data['address'];
            $uData['mobile'] = $dealer->mobile  = $data['mobile'];
            $dealer->city    = $data['city'];
            $dealer->pincode = $data['pincode'];
            $dealer->country = $data['country'];
              
            $dealer->latitude = $data['latitude'];
            $dealer->longitude = $data['longitude'];

           
            if(isset($data['password']) && $data['password'] != ''){
                $uData['password'] = Hash::make($data['password']);
            }
            if (@$data['slug'] == '') {
                $data['slug'] = $this->createSlug($data['name']);
            } else {
                $data['slug'] = $this->createSlug($data['slug']);
            }
            $dealer->slug = $data['slug'];

            $dealerArray = $dealer->toArray();
            $dealerArray = array_filter($dealerArray, function($value) {
                return !empty($value);
            });
            $dealer = new Dealer($dealerArray);
            $dealer->save();

            $uData['type'] = 'Dealer';
            $uData['uid'] = $dealer->id;
            $this->createUser($uData, 'create');

            Toastr::success('Dealer Created Successfully ', 'Success');
            return redirect()->route('dealer.index');
        }
    }
    function createUser($data, $type)
    {
        if ($type == 'create') {
            $user = new User();
        } else {
            $user = User::where('uid', $data['uid'])->where('type', 'Dealer')->first();
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
        $special = Dealer::find($id);
        return view('superadmin.Dealer.view', compact('special', 'id'));
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
        $dealer = Dealer::find($id);
        $hospital = Hospital::all();
        return view('superadmin.Dealer.create', compact('dealer', 'hospital', 'id'));
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
        $dealer = Dealer::find($id);

        $data = $request->all();

        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $dealer->image = $fileName;
        }
        
        if ($request->hasFile('owner_id')) {
            $file = $request->file('owner_id');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $dealer->owner_id = $fileName;
        }
        
        if ($request->hasFile('partner_id')) {
            $file = $request->file('partner_id');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $dealer->partner_id = $fileName;
        }
        if ($request->hasFile('registration_certificate')) {
            $file = $request->file('registration_certificate');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $dealer->registration_certificate = $fileName;
        }
        if ($request->hasFile('gstin_proof')) {
            $file = $request->file('gstin_proof');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $dealer->gstin_proof = $fileName;
        }
        $uData['name'] =  $dealer->name    = $data['name'];
        
        $dealer->partner_name    = $data['partner_name'];
        $dealer->owner_name    = $data['owner_name']; 
        $dealer->about    = $data['about'];
        $dealer->gstin    = $data['gstin']; 
        
        $dealer->about    = $data['about']; 
        $dealer->address    = $data['address']; 
        
        $uData['email'] = $dealer->email   = $data['email'];
        $dealer->address = $data['address'];
        $uData['mobile'] = $dealer->mobile  = $data['mobile'];
        $dealer->city    = $data['city'];
        $dealer->pincode = $data['pincode'];
        $dealer->country = $data['country'];
          
        $dealer->latitude = $data['latitude'];
        $dealer->longitude = $data['longitude'];

       
        if(isset($data['password']) && $data['password'] != ''){
            $uData['password'] = Hash::make($data['password']);
        }
        if (@$data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['name'], $id);
        } else {
            $data['slug'] = $this->createSlug($data['slug'], $id);
        }
        $dealer->slug = $data['slug'];

        array_walk($dealer, function ($v, $k) use ($dealer)  {
            if(empty($v)) unset($dealer->$k);
        });
        $dealer->save();

        $uData['type'] = 'Dealer';
        $uData['uid'] = $id;

        $this->createUser($uData, 'update');
        Toastr::success('Dealer Updated Successfully ', 'Success');
        return redirect()->route('dealer.index');
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
        Dealer::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Dealer Deleted Successfully ', 'Success');
        return redirect()->route('dealer.index');
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
        return Dealer::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
