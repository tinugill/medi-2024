<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Yoeunes\Toastr\Facades\Toastr;
use Session;
use Cache;

class AuthController extends Controller
{
    //login
    public function login(Request $request){
        
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'email' => 'required|email',
                'password' => 'required'
            ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect()->back()
              ->withErrors($validator)
              ->withInput();
        }else{
                $email=$request->email;
                $password=$request->password;
            if (Auth::guard('superadmin')->attempt(['email' => $email, 'password' => $password])) {
                  Toastr::success('Login Successfully ','Success');
                  return redirect('/dashboard');
                } else {
                    Toastr::error('Please enter valid credentials.','Failed');
                    return redirect('/login');
                }
            }
        }
      
        return view('superadmin.index');
    }
    //dashboard
    public function dashboard(){
        return view('superadmin.dashboard');
    }
    //logout
    public function logout(){
        Auth::logout();
        Session::flush();
        Cache::flush();
        Toastr::success('Logout Successfully','Success');
        return redirect('/login');
    }
}
