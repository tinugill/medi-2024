<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Nursing;
use App\Models\Otp;
use Validator;
use Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => 400], 400);
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                if (@$user->is_deleted == '1') {

                    return failResponse('Please contact to admin you are blocked by admin.', [], \Config::get('constants.status_code.INVALID_LOGIN'));
                } else if (@$user->is_verified == '0') {
                    $ret['req_id'] = sendOtp(@$user->id, @$user->type);
                    $ret['type'] =  @$user->type;
                    return successResponse('OTP Sent again please verify', $ret, \Config::get('constants.status_code.SUCCESS'));
                } else {
                   
                    $result['token']   =  $user->createToken('login')->accessToken;
                    $result['id'] =  $user->id;
                    $result['user_id'] =  $user->uid;
                    $result['name']    =  $user->name;
                    $result['email']   =  $user->email;
                    $result['type']   =  $user->type;
                    $result['my_referal']   =  $user->my_referal;
                    $result['joined_from']   =  $user->joined_from;
                    $result['created'] =  $user->created_at;
                    if($result['type'] == 'Nursing'){
                        $n = Nursing::find($user->uid);
                        $result['buero_id']   =  $n->buero_id;
                        $result['buero_type']   =  $n->regis_type;
                    }else if ($result['type'] == 'Ambulance') {
                        $ambulance = Ambulance::find($user->uid); 
                        $result['type_of_user']  = $ambulance->type_of_user; 
                    }else if ($result['type'] == 'Doctor') {
                        $doctor = Doctor::find($user->uid); 
                        $result['hospital_id']  = $doctor->hospital_id; 
                    }


                    return successResponse('User logged in successfully.', $result, \Config::get('constants.status_code.SUCCESS'));
                }
            } else {

                return failResponse('Please enter valid credentials.', [], \Config::get('constants.status_code.INVALID_LOGIN'));
            }
        }
    }
}
