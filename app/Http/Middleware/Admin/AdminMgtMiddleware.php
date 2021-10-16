<?php

namespace App\Http\Middleware\Admin;


use Closure;

class AdminMgtMiddleware
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
        $admin  = auth('admin')->user();
        $url = $request->url();
        $proceed = false;

        switch(true)
        {
            case $url == route('admin.adminmgt.list') :
                 $proceed = $admin->can('view all admin');
                 break;
            case $url == route('admin.admin_mgt.store.view') :
                  $proceed = $admin->can('create admin');
                  break;
            case $url == route('admin.admin_mgt.store') :
                  $proceed = $admin->can('create admin');
                  break;
            case $url == route('admin.adminmgt.show',['admin' => $request->admin ?? 0]) :
                    $proceed = $admin->can('view admins') || $admin->id == $request->admin;
                    break;
            case $url == route('admin.admin_mgt.profile_image.update',['admin' => $request->admin ?? 0]) :
                        $proceed = $admin->can('edit admin') || $admin->id == $request->admin;
                        break;
            case $url == route('admin.admin_mgt.update',['admin' => $request->admin ?? 0]) :
                            $proceed = $admin->can('edit admin') || $admin->id == $request->admin;
                            break;
            case $url == route('admin.adminmgt.remove',['admin' => $request->admin ?? 0]) :
                                $proceed = $admin->can('delete admin') && $admin->id != $request->admin->id;
                                break;
             case $url == route('admin.user_mgt.list') :
                    $proceed = $admin->can('view users');
                     break;
            case $url == route('admin.user_mgt.show',[ 'user' => $request->user ?? 0]) :
                        $proceed = $admin->can('view users');
                         break;
                     
            case $url == route('admin.user_mgt.fund_user',[ 'user' => $request->user ?? 0]) :
                        $proceed = $admin->can('view users');
                         break;
            default : 
                  break;
                  
        }
        //check url and if logged in user can else return to deny
        return ($proceed) ? $next($request) : redirect()->route('admin.dashboard.deny');
    }
}
