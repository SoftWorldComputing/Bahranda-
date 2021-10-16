<?php
namespace App\Classes;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleMgtClass {

  public function __construct()
  {
      $this->permissionRepo = new Permission;
      $this->roleRepo = new Role;
  }

    public function listAllRoleClass($admin)
    {
            return ["status" => "success","message"=> "Roles fetched successfully" ,"roles" => $this->roleRepo->all(),"permissions" => $this->permissionRepo->all()];
    }

    public function getRoleDetails($admin,$role)
    {
        $role = Role::whereName($role)->first();
        if($role){
            $permissions = $role->getAllPermissions()->pluck('id')->toArray();
           return ["status" => "success","message" => "Role fetched successfully","role" => $role,"permissions" => $permissions];
        }else{
           return ["status" => "error","message" => "Error getting role"];
        }

    }


    public function getAllPermissions()
    {
        return ["status" => "success","message"=> "Permissions fetched successfully" ,"permissions" => $this->permissionRepo->all()->groupBy('category')];
    }

    public function createNewRole($admin,$display_name,$description,$permissions)
    {
            if(empty($permissions))
            {
                return ["status" => "error","message" => "One or more permission must be selected"];
            }
            //create new role
            $new_role = Role::create(['name' => strtolower(str_replace(" ","_",$display_name)),'guard_name' => 'admin','description' => $description,'display_name' => $display_name]);
            foreach ($permissions as $permission) {
                $thepermission = Permission::find($permission);
             
                if($thepermission)
                {
                   $new_role->givePermissionTo($thepermission);
                }
            }
            return ["status" => "success","message" => "Role created successfully"];
    }

    public function getRolePermissions($role)
    {
        $role = Role::whereName($role)->first();
        if($role){
            $permissions = $role->getAllPermissions();
           
            return ["status" => "success","message" => "Role fetched successfully","role" => $role];
         }else{
            return ["status" => "error","message" => "Error getting role"];
         }
    }

    public function updateRole($admin,$role,$display_name,$description,$permissions)
    {
        if(empty($permissions))
        {
            return ["status" => "error","message" => "One or more permission must be selected"];
        }
        $role->syncPermissions([]);
        $role->permissions()->detach();
        foreach ($permissions as $permission) {
            $thepermission = Permission::find($permission);
         
            if($thepermission)
            {
               $role->givePermissionTo($thepermission);
            }
        }
        return ["status" => "success","message" => "Role updated successfully"];
    }
   
}
?>