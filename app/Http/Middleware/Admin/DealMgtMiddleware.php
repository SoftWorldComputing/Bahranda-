<?php

namespace App\Http\Middleware\Admin;

use Closure;

class DealMgtMiddleware
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
            case $url == route('admin.partnership.list') :
                 $proceed = $admin->can('see all deals');
                 break;
            case $url == route('admin.partnership.view_partnership',['partnership' => $request->partnership ?? 0]) :
                  $proceed = $admin->can('see all deals');
                  break;
            case $url == route('admin.partnership.assignwarehouse',['partnership' => $request->partnership ?? 0]) :
                  $proceed = $admin->can('assign deal to warehouse');
                 break;
            case $url == route('admin.partnership.change-partnership-status',['partnership' => $request->partnership ?? 0]) :
                  $proceed = $admin->can('change deal status') ;
                  break;
            case $url == route('admin.partnership.by_batch') :
                  $proceed = $admin->can('see all deals') ;
                  break;
            case $url == route('admin.partnership.batch_deals',['batch_no' => $request->batch_no ?? 0]) :
                    $proceed = $admin->can('see all deals');
                    break;
            case $url == route('admin.partnership.batchupdatedeals') :
                  $proceed = $admin->can('change deal status') || $admin->can('assign deal to warehouse');
                  break;
            case $url == route('admin.partnership.real_price_sold',['partnership' => $request->partnership ?? 0]);
               $proceed = $admin->can('change deal status') || $admin->can('assign deal to warehouse');
                 break;
            default : 
                  break;
                  
        }
        //check url and if logged in user can else return to deny
        return ($proceed) ? $next($request) : redirect()->route('admin.dashboard.deny');
    }
}
