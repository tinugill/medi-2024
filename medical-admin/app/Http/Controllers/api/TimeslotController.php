<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timeslot;
use App\Models\Doctor;
use App\Models\User;
use Auth;

class TimeslotController extends Controller
{
  public function addSlot(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      $day    = json_decode($request->day, true);
      for ($i = 0; $i < count($day); $i++) {
        if ($request->id != '') {
          $timeslot = Timeslot::find($request->id);
        } else {
          $timeslot = new Timeslot;
        }
        $timeslot->day = $day[$i];
        $timeslot->slot_interval    = $request->slot_interval;
        $timeslot->shift1_start_at    = $request->shift1_start_at;
        $timeslot->shift1_end_at    = $request->shift1_end_at;
        if($request->shift2_start_at != ''){
          $timeslot->shift2_start_at    = $request->shift2_start_at;
        }
        if($request->shift2_end_at != ''){
          $timeslot->shift2_end_at    = $request->shift2_end_at;
        } 
        $timeslot->doctor_id    = @$user->id;
        $timeslot->save();
      }

      return successResponse('timeslot Created', $user, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function docTimeslot(Request $request)
  {

    $user = Auth::guard('api')->user();
    if ($user) {
      if (@$request->id != '') {
        $data = Timeslot::where('doctor_id', @$user->id)->where('id', $request->id)->where('is_deleted', '0')->first();
      } else {
        $data['Monday'] = Timeslot::where('doctor_id', @$user->id)->where('is_deleted', '0')->where('day', 'Monday')->get();
        $data['Tuesday'] = Timeslot::where('doctor_id', @$user->id)->where('is_deleted', '0')->where('day', 'Tuesday')->get();
        $data['Wednesday'] = Timeslot::where('doctor_id', @$user->id)->where('is_deleted', '0')->where('day', 'Wednesday')->get();
        $data['Thursday'] = Timeslot::where('doctor_id', @$user->id)->where('is_deleted', '0')->where('day', 'Thursday')->get();
        $data['Friday'] = Timeslot::where('doctor_id', @$user->id)->where('is_deleted', '0')->where('day', 'Friday')->get();
        $data['Saturday'] = Timeslot::where('doctor_id', @$user->id)->where('is_deleted', '0')->where('day', 'Saturday')->get();
        $data['Sunday'] = Timeslot::where('doctor_id', @$user->id)->where('is_deleted', '0')->where('day', 'Sunday')->get();
      }


      return successResponse('List', $data, \Config::get('constants.status_code.SUCCESS'));
    } else {

      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
  public function deleteSlot(Request $request)
  {
    $user = Auth::guard('api')->user();
    if ($user) {
      $data = Timeslot::where('id', $request->id)->where('doctor_id', @$user->id)->first();
      if ($data != '') {
        \DB::table('timeslots')
          ->where('id', $request->id)  // find your user by their email
          ->limit(1)  // optional - to ensure only one record is updated.
          ->update(array('is_deleted' => '1'));
        return successResponse('Slot deleted', $data, \Config::get('constants.status_code.SUCCESS'));
      } else {
        return failResponse('Invalid request', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
      }
    } else {
      return failResponse('User does not authenticate.', [], \Config::get('constants.status_code.INTERNAL_SERVER_ERROR'));
    }
  }
}
