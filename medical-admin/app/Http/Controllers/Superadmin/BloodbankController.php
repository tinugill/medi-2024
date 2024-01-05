<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bloodbank;
use App\Models\Bloodbankstock;
use App\Models\BloodbankComponent;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Str;
use Toastr;
use Validator;
use Hash;

class BloodbankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $bloodbank    =   Bloodbank::where('is_deleted','0')->get(); 
        return view('superadmin.Bloodbank.index', compact('bloodbank'));
    }
    public function component()
    { 
        $stock    =   BloodbankComponent::get(); 
        return view('superadmin.Bloodbank.component', compact('stock'));
    }
    public function componentEdit($id = '')
    { 
        $bloodbank = ''; 
        if($id != ''){
            $bloodbank = BloodbankComponent::find($id);
        }
        return view('superadmin.Bloodbank.createComponent', compact('id', 'bloodbank'));
    }
    public function storeComponent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('bloodbank.storeComponent');
        } else {

            $bloodbank = new BloodbankComponent;

            $data = $request->all();
 
            $bloodbank->title    = $data['title'];
            
            $bloodbank->save();
 

            Toastr::success('Component Created Successfully ', 'Success');
            return redirect()->route('bloodbank.component');
        }
    }
    public function updateComponent(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('bloodbank.storeComponent');
        } else {

            $bloodbank = BloodbankComponent::find($id);

            $data = $request->all();
 
            $bloodbank->title    = $data['title'];
            
            $bloodbank->save();
 

            Toastr::success('Component Created Successfully ', 'Success');
            return redirect()->route('bloodbank.component');
        }
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
        $bloodbank = '';
        return view('superadmin.Bloodbank.create', compact('id', 'bloodbank', 'hospital'));
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
            'email' => 'required|email|unique:bloodbanks,email'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('bloodbank.create');
        } else {

            $bloodbank = new Bloodbank;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/hospital_image');
                $file->move($destinationPath, $fileName);
                $bloodbank->image = $fileName;
            }
            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/hospital_image');
                $file->move($destinationPath, $fileName);
                $bloodbank->banner_image = $fileName;
            }
            $bloodbank->name    = $data['name'];
            if($data['owner_name'] != ''){
                $bloodbank->owner_name    = $data['owner_name'];
            }
            $bloodbank->public_number    = $data['public_number'];
            $uData['name'] = $bloodbank->cp_name    = $data['cp_name'];
            if($uData['name'] == ''){
                $uData['name'] = $bloodbank->name;
            }
            // if (isset($data['hospital_id']) && $data['hospital_id'] != '') {
            //     $bloodbank->hospital_id = $data['hospital_id'];
            // }

            $uData['email'] = $bloodbank->email   = $data['email'];
            $bloodbank->address = $data['address'];
            $uData['mobile'] = $bloodbank->mobile  = $data['mobile'];
            $bloodbank->city    = $data['city'];
            $bloodbank->pincode = $data['pincode'];
            $bloodbank->country = $data['country'];
            if(isset($data['days'])){
                $bloodbank->days = json_encode($data['days']);
            }
           
            $bloodbank->about = $data['about'];
            $bloodbank->liscence_no = $data['liscence_no'];
            if ($request->hasFile('liscence_file')) {
                $file = $request->file('liscence_file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/hospital_image');
                $file->move($destinationPath, $fileName);
                $bloodbank->liscence_file = $fileName;
            }
            $bloodbank->latitude = $data['latitude'];
            $bloodbank->longitude = $data['longitude'];

            $uData['password'] = $bloodbank->password = Hash::make($data['password']);

            if ($data['slug'] == '') {
                $data['slug'] = $this->createSlug($data['name']);
            } else {
                $data['slug'] = $this->createSlug($data['slug']);
            }
            $bloodbank->slug = $data['slug'];

            $bloodbankArray = $bloodbank->toArray();
            $bloodbankArray = array_filter($bloodbankArray, function($value) {
                return !empty($value);
            });
            $bloodbank = new Bloodbank($bloodbankArray);
            $bloodbank->save();

            $uData['type'] = 'Bloodbank';
            $uData['uid'] = $bloodbank->id;
            $this->createUser($uData, 'create');

            Toastr::success('Bloodbank Created Successfully ', 'Success');
            return redirect()->route('bloodbank.index');
        }
    }
    function createUser($data, $type)
    {
        if ($type == 'create') {
            $user = new User();
        } else {
            $user = User::where('uid', $data['uid'])->where('type', 'Bloodbank')->first();
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
        $special = Bloodbank::find($id);
        return view('superadmin.Bloodbank.view', compact('special', 'id'));
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
        $bloodbank = Bloodbank::find($id);
        $hospital = Hospital::all();
        return view('superadmin.Bloodbank.create', compact('bloodbank', 'hospital', 'id'));
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
        $bloodbank = Bloodbank::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/hospital_image');
            $file->move($destinationPath, $fileName);
            $bloodbank->image = $fileName;
        }
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/hospital_image');
            $file->move($destinationPath, $fileName);
            $bloodbank->banner_image = $fileName;
        }
        $uData['name'] = $bloodbank->cp_name    = $data['cp_name'];
        $bloodbank->name    = $data['name'];
        if($uData['name'] == ''){
            $uData['name'] = $bloodbank->name;
        }

        // if (isset($data['hospital_id']) && $data['hospital_id'] != '') {
        //     $bloodbank->hospital_id = $data['hospital_id'];
        // }
        $uData['email'] = $bloodbank->email   = $data['email'];
        $bloodbank->address = $data['address'];
        $uData['mobile'] = $bloodbank->mobile  = $data['mobile'];
        $bloodbank->city    = $data['city'];
        if( $data['owner_name'] != ''){
            $bloodbank->owner_name    = $data['owner_name'];
        }
        
        $bloodbank->public_number    = $data['public_number'];
        if(isset($data['days'])){
            $bloodbank->days = json_encode($data['days']);
        }
        
        $bloodbank->about = $data['about'];
        $bloodbank->liscence_no = $data['liscence_no'];
        if ($request->hasFile('liscence_file')) {
            $file = $request->file('liscence_file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/hospital_image');
            $file->move($destinationPath, $fileName);
            $bloodbank->liscence_file = $fileName;
        }

        $bloodbank->pincode = $data['pincode'];
        $bloodbank->country = $data['country'];
        $bloodbank->latitude = $data['latitude'];
        $bloodbank->longitude = $data['longitude'];
        if ($data['password'] != '') {
            $uData['password'] = $bloodbank->password = Hash::make($data['password']);
        }

        if ($data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['name'], $id);
        } else {
            $data['slug'] = $this->createSlug($data['slug'], $id);
        }
        $bloodbank->slug = $data['slug'];
        
        array_walk($bloodbank, function ($v, $k) use ($bloodbank)  {
            if(empty($v)) unset($bloodbank->$k);
        });
        
        $bloodbank->save();

        $uData['type'] = 'Bloodbank';
        $uData['uid'] = $id;

        $this->createUser($uData, 'update');
        Toastr::success('Bloodbank Updated Successfully ', 'Success');
        return redirect()->route('bloodbank.index');
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
        Bloodbank::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Bloodbank Deleted Successfully ', 'Success');
        return redirect()->route('bloodbank.index');
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
        return Bloodbank::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
