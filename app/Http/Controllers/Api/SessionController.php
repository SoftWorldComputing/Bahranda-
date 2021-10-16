<?php

namespace App\Http\Controllers\Api;

use App\Classes\AuthClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    //

    public function __construct()
    {
        $this->authClass = new AuthClass;
        $this->middleware('auth:api', ['except' => ['loginUser','signupUser','confirmPin','forgotPassword','checkPin','changePassword']]);

    }

    public function loginUser(UserLoginRequest $request)
    {

        return $this->authClass->userLogin($request->email,$request->password);
    }

    public function signupUser(SignupRequest $request)
    {
  
        return $this->authClass->signUpUser($request->email,$request->password,$request->first_name,$request->last_name,$request->sex,$request->phone);

    }

    public function confirmPin(Request $request)
    {
        $this->validate($request,[
            "email" => "required|email|exists:users",
            "pin" => "required",
        ]);

        return $this->authClass->confirmPin($request->email,$request->pin);

    }

    public function forgotPassword(Request $request)
    {
        $this->validate($request,[
            "email" => "required|email|exists:users",
        ]);

        return $this->authClass->forgotPassword($request->email);
    }

    public function checkPin(Request $request)
    {
        $this->validate($request,[
            "email" => "required|email|exists:users",
            "pin" => "required",
        ]);

        return $this->authClass->checkPin($request->email,$request->pin);

    }

    public function changePassword(Request $request)
    {
        $this->validate($request,[
            "email" => "required|email|exists:users",
            "pin" => "required",
            "password" => "required|confirmed",
        ]);

        
        return $this->authClass->changePassword($request->email,$request->password,$request->pin);

    }
}
