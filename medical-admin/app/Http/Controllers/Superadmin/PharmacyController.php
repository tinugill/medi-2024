<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pharmacy;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Str;
use Toastr;
use Validator;
use Hash;

use function PHPUnit\Framework\isNull;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pharmacy    =   Pharmacy::where('is_deleted','0')->get();

        return view('superadmin.Pharmacy.index', compact('pharmacy'));
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
        $pharmacy = '';
        return view('superadmin.Pharmacy.create', compact('id', 'pharmacy', 'hospital'));
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
            'email' => 'required|email|unique:pharmacies,email'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('pharmacy.create');
        } else {

            $pharmacy = new Pharmacy;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/pharmacy_image');
                $file->move($destinationPath, $fileName);
                $pharmacy->image = $fileName;
            }
            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/pharmacy_image');
                $file->move($destinationPath, $fileName);
                $pharmacy->banner_image = $fileName;
            }
            if ($request->hasFile('drug_liscence_file')) {
                $file = $request->file('drug_liscence_file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/pharmacy_image');
                $file->move($destinationPath, $fileName);
                $pharmacy->drug_liscence_file = $fileName;
            }
            if ($request->hasFile('owner_id')) {
                $file = $request->file('owner_id');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/pharmacy_image');
                $file->move($destinationPath, $fileName);
                $pharmacy->owner_id = $fileName;
            }
            if ($request->hasFile('partner_id')) {
                $file = $request->file('partner_id');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/pharmacy_image');
                $file->move($destinationPath, $fileName);
                $pharmacy->partner_id = $fileName;
            }
            if ($request->hasFile('pharmacist_regis_upload')) {
                $file = $request->file('pharmacist_regis_upload');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/pharmacy_image');
                $file->move($destinationPath, $fileName);
                $pharmacy->pharmacist_regis_upload = $fileName;
            }
            if ($request->hasFile('gstin_certificate')) {
                $file = $request->file('gstin_certificate');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/pharmacy_image');
                $file->move($destinationPath, $fileName);
                $pharmacy->gstin_certificate = $fileName;
            }
            $uData['name'] = $pharmacy->name    = $data['name'];
            // $pharmacy->hospital_id = $data['hospital_id'];
            $uData['email'] = $pharmacy->email   = $data['email'];
            $pharmacy->address = $data['address'];
            $uData['mobile']  =  $pharmacy->mobile  = $data['mobile'];
            $pharmacy->city    = $data['city'];
            $pharmacy->pincode = $data['pincode'];
            $pharmacy->fax = $data['fax'];
            $pharmacy->country = $data['country'];
            $pharmacy->owner_name = $data['owner_name'];
            $pharmacy->partner_name = $data['partner_name'];
            $pharmacy->pharmacist_name = $data['pharmacist_name'];
            $pharmacy->pharmacist_regis_no = $data['pharmacist_regis_no'];
            $pharmacy->gstin = $data['gstin'];
            $pharmacy->drug_liscence_number = $data['drug_liscence_number'];
            $pharmacy->drug_liscence_valid_upto = $data['drug_liscence_valid_upto'];
            $pharmacy->latitude = $data['latitude'];
            $pharmacy->longitude = $data['longitude'];
            $uData['password'] = $pharmacy->password = Hash::make($data['password']);

            if ($data['slug'] == '') {
                $data['slug'] = $this->createSlug($data['name']);
            } else {
                $data['slug'] = $this->createSlug($data['slug']);
            }
            $pharmacy->slug = $data['slug'];

            $pharmacyArray = $pharmacy->toArray();
            $pharmacyArray = array_filter($pharmacyArray, function($value) {
                return !empty($value);
            });
            $pharmacy = new Pharmacy($pharmacyArray);

            $pharmacy->save();

            $uData['type'] = 'Pharmacy';
            $uData['uid'] = $pharmacy->id;
            $this->createUser($uData, 'create');

            Toastr::success('Pharmacy Created Successfully ', 'Success');
            return redirect()->route('pharmacy.index');
        }
    }
    function createUser($data, $type)
    {
        if ($type == 'create') {
            $user = new User();
        } else {
            $user = User::where('uid', $data['uid'])->where('type', 'Pharmacy')->first();
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
        return Pharmacy::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pharmacy = Pharmacy::find($id);
        return view('superadmin.Pharmacy.view', compact('pharmacy', 'id'));
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
        $pharmacy = Pharmacy::find($id);
        $hospital = Hospital::all();
        return view('superadmin.Pharmacy.create', compact('pharmacy', 'hospital', 'id'));
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
        $pharmacy = Pharmacy::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/pharmacy_image');
            $file->move($destinationPath, $fileName);
            $pharmacy->image = $fileName;
        }
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/pharmacy_image');
            $file->move($destinationPath, $fileName);
            $pharmacy->banner_image = $fileName;
        }
        if ($request->hasFile('drug_liscence_file')) {
            $file = $request->file('drug_liscence_file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/pharmacy_image');
            $file->move($destinationPath, $fileName);
            $pharmacy->drug_liscence_file = $fileName;
        }
        if ($request->hasFile('owner_id')) {
            $file = $request->file('owner_id');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/pharmacy_image');
            $file->move($destinationPath, $fileName);
            $pharmacy->owner_id = $fileName;
        }
        if ($request->hasFile('partner_id')) {
            $file = $request->file('partner_id');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/pharmacy_image');
            $file->move($destinationPath, $fileName);
            $pharmacy->partner_id = $fileName;
        }
        if ($request->hasFile('pharmacist_regis_upload')) {
            $file = $request->file('pharmacist_regis_upload');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/pharmacy_image');
            $file->move($destinationPath, $fileName);
            $pharmacy->pharmacist_regis_upload = $fileName;
        }
        if ($request->hasFile('gstin_certificate')) {
            $file = $request->file('gstin_certificate');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/pharmacy_image');
            $file->move($destinationPath, $fileName);
            $pharmacy->gstin_certificate = $fileName;
        }
        $uData['name'] = $pharmacy->name    = $data['name'];
        // $pharmacy->hospital_id = $data['hospital_id'];
        $uData['email'] = $pharmacy->email   = $data['email'];
        $pharmacy->address = $data['address'];
        $pharmacy->owner_name = $data['owner_name'];
        $pharmacy->partner_name = $data['partner_name'];
        $pharmacy->pharmacist_name = $data['pharmacist_name'];
        $pharmacy->pharmacist_regis_no = $data['pharmacist_regis_no'];
        $pharmacy->gstin = $data['gstin'];
        $uData['mobile'] = $pharmacy->mobile  = $data['mobile'];
        $pharmacy->city    = $data['city'];
        $pharmacy->drug_liscence_number = $data['drug_liscence_number'];
        $pharmacy->drug_liscence_valid_upto = $data['drug_liscence_valid_upto'];
        $pharmacy->fax = $data['fax'];
        $pharmacy->pincode = $data['pincode'];
        $pharmacy->country = $data['country'];
        $pharmacy->latitude = $data['latitude'];
        $pharmacy->longitude = $data['longitude'];
        if ($data['password'] != '') {
            $uData['password'] = $pharmacy->password = Hash::make($data['password']);
        }

        if ($data['slug'] == '') {
            $data['slug'] = $this->createSlug($data['name'], $id);
        } else {
            $data['slug'] = $this->createSlug($data['slug'], $id);
        }
        $pharmacy->slug = $data['slug'];

        array_walk($pharmacy, function ($v, $k) use ($pharmacy)  {
            if(empty($v)) unset($pharmacy->$k);
        });

        $pharmacy->save();

        $uData['type'] = 'Pharmacy';
        $uData['uid'] = $id;

        $this->createUser($uData, 'update');
        Toastr::success('Pharmacy Updated Successfully ', 'Success');
        return redirect()->route('pharmacy.index');
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
        Pharmacy::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('Pharmacy Deleted Successfully ', 'Success');
        return redirect()->route('pharmacy.index');
    }
}
