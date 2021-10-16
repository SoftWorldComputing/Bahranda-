<?php

namespace App\Http\Middleware\Admin;

use App\Models\Admin;
use Closure;

class AccountingMiddleware
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
        $admin = Admin::find($admin->id);
        switch(true)
        {
            case $url == route('admin.accounting.all_account') :
                 $proceed = $admin->can('list accounting');
                 break;
            case $url == route('admin.accounting.withdrwal.requests.view') :
                  $proceed = $admin->can('withdrawal requests list');
                  break;
            case $url == route('admin.accounting.withdrwal.requests.change',['withdrawal_request' => $request->withdrawal_request ?? 0]) :
                 $proceed = $admin->can('withdrawal requests authorize');
                    break;                    
              
            default : 
                  break;
                  
        }
        //check url and if logged in user can else return to deny
        return ($proceed) ? $next($request) : redirect()->route('admin.dashboard.deny');
    }
}
