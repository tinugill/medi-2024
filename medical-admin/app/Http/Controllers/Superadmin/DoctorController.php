<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\Specialities;
use App\Models\Hospital;
use App\Models\User;
use App\Models\Doctor_bank_docs;
use App\Models\Medical_counsiling;
use Illuminate\Support\Str;
use Toastr;
use Validator;
use Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $doctor = Doctor::where('is_deleted', '0')->get();
        return view('superadmin.doctor.index', compact('doctor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = '';
        $doctor = '';
        $specialization =  Specialization::all();
        $specialities  = Specialities::all();
        $hospital = Hospital::all();
        $medical_counsiling = Medical_counsiling::all();
        return view('superadmin.doctor.create', compact('id', 'doctor', 'specialization', 'specialities', 'hospital', 'medical_counsiling'));
        //
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
            'full_name' => 'required',
            'email' => 'required|email|unique:doctors,email',
            'mobile' => 'required|max:14',
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('doctor.create');
        } else {

            $doctor = new Doctor;
            $doctor_bank = new Doctor_bank_docs;
            $data = $request->all();

            $uData['name'] = $doctor->full_name = $data['full_name'];
            $uData['email'] = $doctor->email = $data['email'];
            $uData['mobile'] = $doctor->mobile = $data['mobile'];
            $uData['type'] = 'Doctor';

            if(isset($data['type'])){
                $doctor->type = $data['type'];
            }
            if(isset($data['gender'])){
                $doctor->gender = $data['gender'];
            }
            $doctor->user_id = '1';
            if (isset($data['specialization_id']) && $data['specialization_id'] != '') {
                $doctor->specialization_id =  json_encode($data['specialization_id']);
            }
            if (isset($data['specialities_id']) && $data['specialities_id'] != '') {
             $doctor->specialities_id =  json_encode($data['specialities_id']);
            }
            if ($request->hasFile('degree_file')) {
                $file = $request->file('degree_file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/doctor_image');
                $file->move($destinationPath, $fileName);
                $doctor->degree_file = $fileName;
            }
            if (isset($data['working_days']) && $data['working_days'] != '') {
                $doctor->working_days = json_encode($data['working_days']);
            }
            $doctor->doctor_image = 'dummy.png';
            if ($request->hasFile('doctor_image')) {
                $file = $request->file('doctor_image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/doctor_image');
                $file->move($destinationPath, $fileName);
                $doctor->doctor_image = $fileName;
            }
            $doctor->doctor_banner = 'dr-list-banner.jpg';
            if ($request->hasFile('doctor_banner')) {
                $file = $request->file('doctor_banner');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/doctor_image');
                $file->move($destinationPath, $fileName);
                $doctor->doctor_banner = $fileName;
            }
            $doctor->registration_certificate = 'dr-list-banner.jpg';
            if ($request->hasFile('registration_certificate')) {
                $file = $request->file('registration_certificate');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/doctor_image');
                $file->move($destinationPath, $fileName);
                $doctor->registration_certificate = $fileName;
            }
            if ($request->hasFile('letterhead')) {
                $file = $request->file('letterhead');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/doctor_image');
                $file->move($destinationPath, $fileName);
                $doctor->letterhead = $fileName;
            }
            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/doctor_image');
                $file->move($destinationPath, $fileName);
                $doctor->signature = $fileName;
            }
            //$doctor->appointment_timing = $data['appointment_timing'];

            $doctor->home_visit = $data['home_visit'];
            $doctor->consultancy_fee = $data['consultancy_fee'];
            $doctor->home_consultancy_fee = $data['home_consultancy_fee'];
            $doctor->online_consultancy_fee = $data['online_consultancy_fee'];
            $doctor->designation = $data['designation'];
            $doctor->about = $data['about'];
            $doctor->award = $data['award'];
            $doctor->experience = $data['experience'];
            $doctor->memberships_detail = $data['memberships_detail'];
            $doctor->registration_details = $data['registration_details'];
            if(isset($data['medical_counsiling']) && $data['medical_counsiling'] != ''){
                $doctor->medical_counsiling = $data['medical_counsiling'];
            }
            
            if ($data['latitude'] == '') {
                $data['latitude'] = 0;
            }
            if ($data['longitude'] == '') {
                $data['longitude'] = 0;
            }
            $doctor->latitude = $data['latitude'];
            $doctor->longitude = $data['longitude'];
            if (isset($data['hospital_id']) && $data['hospital_id'] != '') {
                $doctor->hospital_id = $data['hospital_id'];
            } else {
                $doctor->hospital_id = 0;
            }

            $doctor->city = $data['city'];
            $doctor->pincode = $data['pincode'];
            if (@$data['slug'] == '') {
                $data['slug'] = $this->createSlug($data['full_name']);
            } else {
                $data['slug'] = $this->createSlug($data['slug']);
            }
            $doctor->slug = $data['slug'];
            $doctor->country = $data['country'];
            $doctor->address = $data['address'];
            $uData['password'] = $doctor->password = Hash::make($data['password']);


            $doctorArray = $doctor->toArray();
            $doctorArray = array_filter($doctorArray, function($value) {
                return !empty($value);
            });
            $doctor = new Doctor($doctorArray);
            $doctor->save();

            $uData['uid'] = $doctor->id;

            $doctor_bank->doctor_id =  $doctor->id;
            $doctor_bank->name =  $data['name_on_bank'];
            if($doctor_bank->name == ''){
                $doctor_bank->name = $doctor->full_name;
            }
            $doctor_bank->bank_name =  $data['bank_name'];
            $doctor_bank->branch_name =  $data['branch_name'];
            $doctor_bank->ifsc =  $data['ifsc'];
            $doctor_bank->ac_no =  $data['ac_no'];
            $doctor_bank->ac_type =  $data['ac_type'];
            $doctor_bank->micr_code =  $data['micr_code'];
            $doctor_bank->pan_no =  $data['pan_no'];

            $doctor_bank->cancel_cheque = '';
            if ($request->hasFile('cancel_cheque')) {
                $file = $request->file('cancel_cheque');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/doctor_image');
                $file->move($destinationPath, $fileName);
                $doctor_bank->cancel_cheque = $fileName;
            }
            $doctor_bank->pan_image = '';
            if ($request->hasFile('pan_image')) {
                $file = $request->file('pan_image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/doctor_image');
                $file->move($destinationPath, $fileName);
                $doctor_bank->pan_image = $fileName;
            }

            $doctor_bankArray = $doctor_bank->toArray();
            $doctor_bankArray = array_filter($doctor_bankArray, function($value) {
                return !empty($value);
            });
            $doctor_bank = new Doctor_bank_docs($doctor_bankArray);
            $doctor_bank->save();
            //CREATE DATA IN USER TABLE
            $this->createUser($uData, 'create');

            Toastr::success('Doctor Created Successfully ', 'Success');
            return redirect()->route('doctor.index');
        }
    }
    function createUser($data, $type)
    {
        if ($type == 'create') {
            $user = new User();
        } else {
            $user = User::where('uid', $data['uid'])->where('type', 'Doctor')->first();
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
        $specialization =  Specialization::all();
        $specialities  = Specialities::all();
        $hospital = Hospital::all();
        $doctor = Doctor::find($id);
        $Doctor_bank_docs = Doctor_bank_docs::where('doctor_id', $id)->first();
        $medical_counsiling = Medical_counsiling::all();
        return view('superadmin.doctor.create', compact('id', 'doctor', 'specialization', 'specialities', 'hospital', 'medical_counsiling', 'Doctor_bank_docs'));
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
        $doctor = Doctor::find($id);
        $doctor_bank = Doctor_bank_docs::where('doctor_id', $id)->first();
        if(empty($doctor_bank)){
            $doctor_bank = new Doctor_bank_docs;
            $doctor_bank->doctor_id = $id;
        }
        $data = $request->all();

        $uData['uid'] = $id;
        $uData['name'] = $doctor->full_name = $data['full_name'];
        $uData['email'] = $doctor->email = $data['email'];
        $uData['mobile'] = $doctor->mobile = $data['mobile'];
        $uData['type'] = 'Doctor';
        if (@$data['password'] != '') {
            $uData['password'] = $doctor->password = Hash::make($data['password']);
        }
        if(isset($data['type'])){
            $doctor->type = $data['type'];
        }
        
        if(isset($data['gender'])){
            $doctor->gender = $data['gender'];
        }
        $doctor->user_id = '1';
        if (isset($data['specialization_id']) && $data['specialization_id'] != '') {
         $doctor->specialization_id =  json_encode($data['specialization_id']);
        }
        if (isset($data['specialities_id']) && $data['specialities_id'] != '') {
         $doctor->specialities_id =  json_encode($data['specialities_id']);
        }
        if ($request->hasFile('degree_file')) {
            $file = $request->file('degree_file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/doctor_image');
            $file->move($destinationPath, $fileName);
            $doctor->degree_file = $fileName;
        }
        if (isset($data['working_days']) && $data['working_days'] != '') {
            $doctor->working_days = json_encode($data['working_days']);
        }
        if ($request->hasFile('doctor_image')) {
            $file = $request->file('doctor_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/doctor_image');
            $file->move($destinationPath, $fileName);
            $doctor->doctor_image = $fileName;
        }
        if ($request->hasFile('doctor_banner')) {
            $file = $request->file('doctor_banner');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/doctor_image');
            $file->move($destinationPath, $fileName);
            $doctor->doctor_banner = $fileName;
        }
        $doctor->registration_certificate = 'dr-list-banner.jpg';
        if ($request->hasFile('registration_certificate')) {
            $file = $request->file('registration_certificate');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/doctor_image');
            $file->move($destinationPath, $fileName);
            $doctor->registration_certificate = $fileName;
        }
        if ($request->hasFile('letterhead')) {
            $file = $request->file('letterhead');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/doctor_image');
            $file->move($destinationPath, $fileName);
            $doctor->letterhead = $fileName;
        }
        if ($request->hasFile('signature')) {
            $file = $request->file('signature');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/doctor_image');
            $file->move($destinationPath, $fileName);
            $doctor->signature = $fileName;
        }
        //$doctor->appointment_timing = $data['appointment_timing'];

        $doctor->home_visit = $data['home_visit'];
        $doctor->consultancy_fee = $data['consultancy_fee'];
        $doctor->home_consultancy_fee = $data['home_consultancy_fee'];
        $doctor->online_consultancy_fee = $data['online_consultancy_fee'];
        $doctor->designation = $data['designation'];
        $doctor->about = $data['about'];
        $doctor->award = $data['award'];
        $doctor->experience = $data['experience'];
        $doctor->memberships_detail = $data['memberships_detail'];
        $doctor->registration_details = $data['registration_details'];
        if(isset($data['medical_counsiling']) && $data['medical_counsiling'] != ''){
            $doctor->medical_counsiling = $data['medical_counsiling'];
        }
        if ($data['latitude'] == '') {
            $data['latitude'] = 0;
        }
        if ($data['longitude'] == '') {
            $data['longitude'] = 0;
        }
        $doctor->latitude = $data['latitude'];
        $doctor->longitude = $data['longitude'];
        if (isset($data['hospital_id']) && $data['hospital_id'] != '') {
            $doctor->hospital_id = $data['hospital_id'];
        } else {
            $doctor->hospital_id = 0;
        }
        $doctor->city = $data['city'];
        $doctor->pincode = $data['pincode'];
        if (@$data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['full_name'], $id);
        } else {
            $data['slug'] = $this->createSlug($data['slug'], $id);
        }
        $doctor->slug = $data['slug'];
        $doctor->country = $data['country'];
        $doctor->address = $data['address'];
         
        $doctor->save();


        $doctor_bank->doctor_id =  $doctor->id;
        $doctor_bank->name =  $data['name_on_bank'];
        if($doctor_bank->name == ''){
            $doctor_bank->name = $doctor->full_name;
        }
       
        $doctor_bank->bank_name =  $data['bank_name'];
        $doctor_bank->branch_name =  $data['branch_name'];
        $doctor_bank->ifsc =  $data['ifsc'];
        $doctor_bank->ac_no =  $data['ac_no'];
        $doctor_bank->ac_type =  $data['ac_type'];
        $doctor_bank->micr_code =  $data['micr_code'];
        $doctor_bank->pan_no =  $data['pan_no'];

        $doctor_bank->cancel_cheque = '';
        if ($request->hasFile('cancel_cheque')) {
            $file = $request->file('cancel_cheque');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/doctor_image');
            $file->move($destinationPath, $fileName);
            $doctor_bank->cancel_cheque = $fileName;
        }
        $doctor_bank->pan_image = '';
        if ($request->hasFile('pan_image')) {
            $file = $request->file('pan_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/doctor_image');
            $file->move($destinationPath, $fileName);
            $doctor_bank->pan_image = $fileName;
        }

        array_walk($doctor_bank, function ($v, $k) use ($doctor_bank)  {
            if(empty($v)) unset($doctor_bank->$k);
        });
        $doctor_bank->save();

        $this->createUser($uData, 'update');

        Toastr::success('Doctor Updated Successfully ', 'Success');
        return redirect()->route('doctor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Doctor::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Doctor Deleted Successfully ', 'Success');
        return redirect()->route('doctor.index');
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
        return Doctor::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
