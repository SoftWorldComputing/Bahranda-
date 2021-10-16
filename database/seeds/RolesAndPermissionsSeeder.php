<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $super_admin = Role::updateOrCreate(['name' => 'super_admin','guard_name' => 'admin','description' => 'Super admin with every permissions','display_name' => 'Super Admin']);
        $permissions = config('system_permissions.permissions');

      
        foreach ($permissions as $permission) {
            $permission = Permission::updateOrCreate(['name' => $permission['permission'],'description' => $permission['description'],'guard_name' => 'admin',"category" => $permission['category']]);
            $super_admin->givePermissionTo($permission);
        }

        $admin = App\Models\Admin::first();
        $admin->assignRole($super_admin);
    }
}