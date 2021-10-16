<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\AdminClass;
class Sessioncontroller extends Controller
{
    public function __construct()
    {
        $this->adminClass = new AdminClass;
    }
    //
    public function LoginView()
    {
        return view('auth.login');
    }

    public function Login(Request $request)
    {
        $resp =  $this->adminClass->loginAdmin($request->email,$request->password);
        if($resp && $resp['status'] == "success")
        {
            // flash($resp['message'])->success();
            return redirect()->route('admin.dashboard.index');
        }else{
            flash($resp['message'])->error();
            return redirect()->back();
        }
    }

    public function ForgetPassword()
    {
        return view('auth.forgot_password');

    }

    public function SendPasswordReset(Request $request)
    {
        $resp =  $this->adminClass->sendPasswordReset($request->email);
        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
            return redirect()->back();
        }else{
            flash($resp['message'])->error();
            return redirect()->back();
        }
    }

    public function PasswordResetView(Request $request)
    {
        $resp =  $this->adminClass->activateUser($request->email,$request->token);
        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
        }else{
            flash($resp['message'])->error();

        }
        return view('auth.password_reset',$resp);

    }

    public function PasswordReset(Request $request)
    {
        $resp = $this->adminClass->changePassword($request->email,$request->password);
        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
            return redirect()->route('admin.login');
        }else{
            flash($resp['message'])->error();
            return redirect()->back();
        }
    }

   public function AdminVerificationView(Request $request)
   {
        $resp =  $this->adminClass->verifyUser($request->email,$request->token);
        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
        }else{
            flash($resp['message'])->error();

        }
        return view('auth.password_reset',$resp);

   }
}
