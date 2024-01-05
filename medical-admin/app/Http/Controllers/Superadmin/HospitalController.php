<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Procedures;
use App\Models\Specialities;
use App\Models\Facilities;
use App\Models\Empanelments;
use App\Models\User;
use Illuminate\Support\Str;
use Toastr;
use Validator;
use Hash; 

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospital = Hospital::with('procedure', 'specialities')->where('is_deleted', '0')->get();
        return view('superadmin.hospital.index', compact('hospital'));
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
        $hospital = '';
        $procedure       =       Procedures::all();
        $specialities    =       Specialities::all();
        $Facilities    =       Facilities::all();
        $Empanelments    =       Empanelments::all();
        return view('superadmin.hospital.create', compact('id', 'hospital', 'procedure', 'specialities', 'Facilities', 'Empanelments'));
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
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'country' => 'required',
            'beds_quantity' => 'required',
            'specialities_id' => 'required',
            'procedures_id' => 'required'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
        } else {

            $hospital = new Hospital;

            $data = $request->all();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/hospital_image');
                $file->move($destinationPath, $fileName);
                $hospital->image = $fileName;
            }
            if ($request->hasFile('registration_file')) {
                $file = $request->file('registration_file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/hospital_image');
                $file->move($destinationPath, $fileName);
                $hospital->registration_file = $fileName;
            }
            if ($request->hasFile('accredition_certificate')) {
                $file = $request->file('accredition_certificate');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/hospital_image');
                $file->move($destinationPath, $fileName);
                $hospital->accredition_certificate = $fileName;
            }
            $hospital->name    = $data['name'];
            $hospital->phone_no  = $data['phone_no'];
            $hospital->address = $data['address'];
            $hospital->city    = $data['city'];
            $hospital->pincode = $data['pincode'];
            $hospital->country = $data['country'];
            $hospital->beds_quantity   = $data['beds_quantity'];
            $hospital->registration_details   = $data['registration_details'];
            $hospital->accredition_details   = $data['accredition_details'];
            $hospital->about   = $data['about'];
            $hospital->latitude   = $data['latitude'];
            $hospital->longitude   = $data['longitude'];
            $hospital->type   = $data['type'];
            $hospital->specialities_id = json_encode($data['specialities_id']);
            $hospital->facilities_avialable = json_encode($data['facilities_avialable']);
            $hospital->empanelments = json_encode($data['empanelments']);
            $hospital->procedures_id   = json_encode($data['procedures_id']);
            if (@$data['slug'] == '') {
                $data['slug'] = $this->createSlug($data['name']);
            } else {
                $data['slug'] = $this->createSlug($data['slug']);
            }
            $hospital->slug            = $data['slug'];

            $hospital->save();

            $uData['name'] = $data['contact_person_name'];
            $uData['email'] = $data['email'];
            $uData['mobile']  = $data['mobile'];
            $uData['type'] = 'Hospital';
            $uData['password'] = Hash::make($data['password']);
            $uData['uid'] = $hospital->id;
            $this->createUser($uData, 'create');
            Toastr::success('Hospital Created Successfully ', 'Success');
            return redirect()->route('hospital.index');
        }
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
        //
        $hospital        =       Hospital::find($id);
        $Facilities    =       Facilities::all();
        $Empanelments    =       Empanelments::all();
        $procedure       =       Procedures::all();
        $specialities    =       Specialities::all();
        $User    =       User::where('uid', $id)->where('type', 'Hospital')->first();
        return view('superadmin.hospital.create', compact('id', 'hospital', 'procedure', 'specialities', 'Facilities', 'Empanelments', 'User'));
    }
    function createUser($data, $type)
    {
        if ($type == 'create') {
            $user = new User();
        } else {
            $user = User::where('uid', $data['uid'])->where('type', 'Hospital')->first();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $hospital = Hospital::find($id);;
        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/hospital_image');
            $file->move($destinationPath, $fileName);
            $hospital->image = $fileName;
        }
        if ($request->hasFile('registration_file')) {
            $file = $request->file('registration_file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/hospital_image');
            $file->move($destinationPath, $fileName);
            $hospital->registration_file = $fileName;
        }
        if ($request->hasFile('accredition_certificate')) {
            $file = $request->file('accredition_certificate');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/hospital_image');
            $file->move($destinationPath, $fileName);
            $hospital->accredition_certificate = $fileName;
        }
        $hospital->name    = $data['name'];
        $hospital->phone_no  = $data['phone_no'];
        $hospital->address = $data['address'];
        $hospital->city    = $data['city'];
        $hospital->pincode = $data['pincode'];
        $hospital->country = $data['country'];
        $hospital->beds_quantity   = $data['beds_quantity'];
        $hospital->registration_details   = $data['registration_details'];
        $hospital->accredition_details   = $data['accredition_details'];
        $hospital->about   = $data['about'];
        $hospital->latitude   = $data['latitude'];
        $hospital->longitude   = $data['longitude'];
        $hospital->type   = $data['type'];
        $hospital->specialities_id = json_encode($data['specialities_id']);
        $hospital->facilities_avialable = json_encode($data['facilities_avialable']);
        $hospital->empanelments = json_encode($data['empanelments']);
        $hospital->procedures_id   = json_encode($data['procedures_id']);
        if (@$data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['name'], $id);
        } else {
            $data['slug'] = $this->createSlug($data['slug'], $id);
        }
        $hospital->slug            = $data['slug'];
        $hospital->save();


        $uData['name'] = $data['contact_person_name'];
        $uData['email'] = $data['email'];
        $uData['mobile']  = $data['mobile'];
        $uData['type'] = 'Hospital';
        if (@$data['password'] != '') {
            $uData['password'] = Hash::make($data['password']);
        }
        $uData['uid'] = $id;
        $this->createUser($uData, 'update');

        // Hospital::where('id',$id)->update($data);
        Toastr::success('Hospital Updated Successfully ', 'Success');
        return redirect()->route('hospital.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Hospital::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Hospital Deleted Successfully ', 'Success');
        return redirect()->route('hospital.index');
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
        return Hospital::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
