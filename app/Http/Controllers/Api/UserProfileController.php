<?php

namespace App\Http\Controllers\Api;

use App\Classes\UserProfileClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserProfileRequest;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    //
    public function __construct()
    {
        $this->userProfileClass = new UserProfileClass;
    }

    public function getUserProfile(Request $request)
    {
        return $this->userProfileClass->getUserProfile($request->user());
    }


    public function updateProfile(UserProfileRequest $request)
    {
        return $this->userProfileClass->updateProfile($request->user(),$request->first_name,$request->last_name,$request->sex,$request->phone);
    }

    public function changePassword(UserChangePasswordRequest $request)
    {
        return $this->userProfileClass->changePassword($request->user(),$request->current_password,$request->new_password);
    }
}
