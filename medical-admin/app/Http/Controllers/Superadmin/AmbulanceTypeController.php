<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AmbulanceType;
use Illuminate\Support\Str;
use Toastr;
use Validator;


class AmbulanceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ambulanceType    =   AmbulanceType::where('is_deleted', '0')->get();

        return view('superadmin.AmbulanceType.index', compact('ambulanceType'));
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
        $ambulanceType = '';
        return view('superadmin.AmbulanceType.create', compact('id', 'ambulanceType'));
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
            'title' => 'required'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed', ['timeOut' => 2000]);
            }
            return redirect()->route('ambulanceType.create');
        } else {

            $ambulanceType = new AmbulanceType;

            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $fileName);
                $ambulanceType->image = $fileName;
            }
            $ambulanceType->title    = $data['title']; 
            
            $ambulanceType->save();
            Toastr::success('AmbulanceType Created Successfully ', 'Success');
            return redirect()->route('ambulanceType.index');
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
        $ambulanceType = AmbulanceType::find($id);
        return view('superadmin.AmbulanceType.view', compact('ambulanceType', 'id'));
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
        $ambulanceType = AmbulanceType::find($id);

        return view('superadmin.AmbulanceType.create', compact('ambulanceType', 'id'));
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
        $ambulanceType = AmbulanceType::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);
            $ambulanceType->image = $fileName;
        }
        $ambulanceType->title    = $data['title']; 

        $ambulanceType->save();
        Toastr::success('AmbulanceType Updated Successfully ', 'Success');
        return redirect()->route('ambulanceType.index');
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
        AmbulanceType::where('id', $id)->update(['is_deleted' => '1']);
        Toastr::success('AmbulanceType Deleted Successfully ', 'Success');
        return redirect()->route('ambulanceType.index');
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
        return AmbulanceType::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
