<?php

namespace App\Http\Controllers\User;

use App\Classes\PartnershipMgtClass;
use App\Classes\UserMgtClass;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\FundUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    //

    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth:admin','adminmgt']);
        $this->userMgtClass = new UserMgtClass;
        $this->partnershipMgtClass = new PartnershipMgtClass;
    }
  
    public function fundUser(FundUserRequest $request)
    {
        $resp = $this->userMgtClass->fundUser($request->user,$request->amount);
       return $resp;
    }

    public function show(Request $request)
    {
        if($request->user_status)
        {
            $feedback =  $this->userMgtClass->changeUserStatus($request->user,$request->user_status);
            if($feedback && $feedback['status'] == "success")
            {
                flash($feedback['message'])->success();
            }else{
                flash($feedback['message'])->error();
    
            }
            return redirect()->back();
        }
        $resp = $this->userMgtClass->getUserDetails($request->user);
        $resp['deals'] = $this->partnershipMgtClass->getUserPartnership($request->user);
       
        return view('dashboard.users.show',$resp);
    }

    public function list(Request $request)
    {
        $resp = $this->userMgtClass->getUserList($request->keyword);
        return view('dashboard.users.user_list',$resp);
    }
}
