<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialities;
use App\Models\Specialization;
use App\Models\Procedures;
use App\Models\Facilities;
use DB;
use Auth;

class SpecialitiesController extends Controller
{
  public function specialitiesTopDoc(Request $request)
  {
    $doctor_list = DB::table('doctors')->where('is_deleted', '0')->whereRaw('json_contains(specialities_id, \'["' . $request->sid . '"]\')')->limit(4)->get();
    return successResponse('List', $doctor_list, \Config::get('constants.status_code.SUCCESS'));
  }
  public function proceduresList(Request $request)
  {
    if ($request->id) {
      $Procedures = Procedures::where('id', $request->id)->first();
    } else {
      $Procedures = Procedures::where('is_deleted', '0')->get();
    }

    return successResponse('Procedures List', $Procedures, \Config::get('constants.status_code.SUCCESS'));
  }
  public function facilitiesList(Request $request)
  {
    if ($request->id) {
      $Facilities = Facilities::where('id', $request->id)->first();
    } else {
      $Facilities = Facilities::where('is_deleted', '0')->get();
    }

    return successResponse('Facilities List', $Facilities, \Config::get('constants.status_code.SUCCESS'));
  }
  public function specialitiesList(Request $request)
  {
    if ($request->id) {
      $Specialities = Specialities::where('id', $request->id)->first();
      $Specialities['image'] = asset('specialities_image/' . $Specialities['image']);
    } else if (isset($request->specialization_id) && $request->specialization_id != '') {
      //$Specialities = Specialities::whereIn('specialization_id', explode(',', $request->specialization_id))->get();
      $Specialities = Specialities::where('is_deleted', '0')->get();
    } else {
      $Specialities = Specialities::where('is_deleted', '0')->get();
    }

    return successResponse('Specialities List', $Specialities, \Config::get('constants.status_code.SUCCESS'));
  }
  public function specializationList(Request $request)
  {
    if ($request->id) {
      $Specialities = Specialization::where('id', $request->id)->first();
      $Specialities['image'] = asset('specialities_image/' . $Specialities['image']);
    } else {
      $Specialities = Specialization::where('is_deleted', '0')->get();
    }

    return successResponse('Specialization List', $Specialities, \Config::get('constants.status_code.SUCCESS'));
  }
}
