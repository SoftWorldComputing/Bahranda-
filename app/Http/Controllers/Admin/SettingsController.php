<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\AdminMgtClass;
use App\Http\Requests\StoreNewAdminRequest;
use App\Models\Admin;

class SettingsController extends Controller
{
    //
    public function __construct()
    {
   
        $this->middleware(['auth:admin']);
        $this->adminMgtClass = new AdminMgtClass;
    }

    public function ChangePasswordView()
    {
        return view('dashboard.settings.change_password');
    }

    public function ChangePassword(Request $request,Admin $admin)
    {
        if(auth('admin')->user()->id  != $admin->id)
        {
            flash("Invalid operation")->error();
            return redirect()->back();
        }

        if($request->new_password  != $request->new_password_confirmation)
        {
            flash("Password confirmation not matched")->error();
            return redirect()->back();
        }
        $resp = $this->adminMgtClass->adminChangePassword($admin,$request->old_password,$request->new_password);
        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
        }else{
            flash($resp['message'])->error();

        }
        return redirect()->back();
    }
}
