<?php

namespace App\Http\Middleware\Admin;

use Closure;

class RoleManagementMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //get the url it going
        $admin  = auth('admin')->user();
        $url = $request->url();
        $proceed = false;

        switch(true)
        {
            case $url == route('admin.rolemgt.list') :
                 $proceed = $admin->can('view all roles');
                 break;
            case $url == route('admin.rolemgt.create-role.view') :
                  $proceed = $admin->can('create roles');
                  break;
            case $url == route('admin.rolemgt.remove-role') :
                  $proceed = $admin->can('remove role');
                  break;
            case $url == route('admin.rolemgt.view',['role' => $request->role]) :
                    $proceed = $admin->can('view all roles');
                    break;
            case $url == route('admin.rolemgt.update',['role' => $request->role]) :
                        $proceed = $admin->can('update role');
                        break;
            default : 
                  break;
                  
        }
        //check url and if logged in user can else return to deny
        return ($proceed) ? $next($request) : redirect()->route('admin.dashboard.deny');
    }
}
