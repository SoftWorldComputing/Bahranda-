<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Classes\RoleMgtClass;
use App\Http\Requests\StoreNewRoleRequest;
use Spatie\Permission\Models\Role;
class RoleManagementController extends BaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth:admin','rolemgt']);
        $this->roleMgtClass = new RoleMgtClass;
    }
    //$this->admin is from a parent controller

    public function ListRoles(Request $request)
    {
            $resp = $this->roleMgtClass->listAllRoleClass($this->admin);
            return view('dashboard.settings.rolemgt.role_mgt',$resp);
    }
    //
    public function CreateNewRoleView()
    {
        $resp = $this->roleMgtClass->getAllPermissions();
        return view('dashboard.settings.rolemgt.add_role',$resp);
    }

    public function UpdateRoleView(Request $request)
    {
      
        $resp = $this->roleMgtClass->getRoleDetails($this->admin,$request->role);
        $all_perm = $this->roleMgtClass->getAllPermissions();
        if($resp && $resp['status'] == "success" && $all_perm['status'] == "success")
        {
          
            $resp["all_perms"] = $all_perm['permissions'];
           return view('dashboard.settings.rolemgt.view_role',$resp);
        }else{
            abort(404);
        }
    }

    public function CreateNewRole(StoreNewRoleRequest $request)
    {
        $resp = $this->roleMgtClass->createNewRole($this->admin,$request->display_name,$request->description,$request->permissions);
        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
        }else{
            flash($resp['message'])->error();

        }
        return redirect()->back();
    }

   public function UpdateRole(StoreNewRoleRequest $request, Role $role )
   {
        $resp = $this->roleMgtClass->updateRole($this->admin,$role,$request->display_name,$request->description,$request->permissions);
        if($resp && $resp['status'] == "success")
        {
            flash($resp['message'])->success();
        }else{
            flash($resp['message'])->error();

        }
        return redirect()->back();
    }
}
