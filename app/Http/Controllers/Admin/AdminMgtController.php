<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Classes\AdminMgtClass;
use App\Http\Requests\StoreNewAdminRequest;
use App\Models\Admin;
class AdminMgtController extends BaseController
{

    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth:admin','adminmgt']);
        $this->adminMgtClass = new AdminMgtClass;
    }
    public function AdminList(Request $request)
    {
        $resp = $this->adminMgtClass->getAdminList($request->keyword,$request->role);
        return view('dashboard.users.admin.admin_list',$resp);
    }


    public function ShowAdmin(Request $request)
    {
        $resp = $this->adminMgtClass->getAdminDetails($request->admin);
        if($resp && $resp['status'] == "success")
        {
            return view('dashboard.users.admin.admin_profile',$resp);
  
        }else{
            return abort(404);
        }
        
    }

    public function UpdateAdmin(Request $request)
    {
        $resp = $this->adminMgtClass->updateAdmin($this->admin,$request->admin,$request->first_name,$request->last_name,$request->phone,$request->sex,$request->role,$request->status);
        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
        }else{
            flash($resp['message'])->error();

        }
        return redirect()->back();
    }

    public function CreateAdminView(Request $request)
    {
        $roles = $this->adminMgtClass->getRoles();
        return view('dashboard.users.admin.add_admin',["roles" =>$roles ]);
        
    }

    public function CreateAdmin(StoreNewAdminRequest $request)
    {
        $resp = $this->adminMgtClass->createNewAdmin($request->admin,$request->email,$request->first_name,$request->last_name,$request->phone,$request->sex,$request->role);
        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
        }else{
            flash($resp['message'])->error();

        }
        return redirect()->back();
    }

    public function UpdateAdminProfileImage(Request $request)
    {
        //check maybe image is set
        $profile_image = $request->file('profile_image')->store('images');
        $resp = $this->adminMgtClass->updtaeAdminProfileImage($this->admin,$profile_image);
        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
        }else{
            flash($resp['message'])->error();

        }
        return redirect()->back();
    }

   public function DeleteAdmin(Request $request , Admin $admin)
   {
        $resp = $this->adminMgtClass->removeAdmin($this->admin,$admin);
        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
        }else{
            flash($resp['message'])->error();

        }
        return redirect()->back();

   }

}
