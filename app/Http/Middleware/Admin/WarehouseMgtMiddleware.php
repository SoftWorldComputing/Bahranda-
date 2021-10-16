<?php

namespace App\Http\Middleware\Admin;

use Closure;

class WarehouseMgtMiddleware
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
            case $url == route('admin.warehousemgt.list') :
                 $proceed = $admin->can('see all warehouse');
                 break;
            case $url == route('admin.warehousemgt.add_warehouse.view') :
                  $proceed = $admin->can('add warehouse');
                  break;
            case $url == route('admin.warehousemgt.add_warehouse') :
                  $proceed = $admin->can('add warehouse');
                 break;
            case $url == route('admin.warehousemgt.show_warehouse',['warehouse' => $request->warehouse ?? 0]) :
                  $proceed = $admin->can('view warehouse') ;
                  break;
            case $url == route('admin.warehousemgt.checkout.view',['warehouse' => $request->warehouse ?? 0]) :
                  $proceed = $admin->can('checkout warehouse') ;
                  break;
            case $url == route('admin.warehousemgt.checkout.requests.all') :
                    $proceed = $admin->can('checkout warehouse');
                    break;
            case $url == route('admin.warehousemgt.checkout.requests.all.data',['batch_no' => $request->batch_no ?? 0]) :
                  $proceed = $admin->can('checkout warehouse');
                  break;
            case $url == route('admin.warehousemgt.checkout.requests.submit',['warehouse' => $request->warehouse ?? 0]) :
                    $proceed = $admin->can('checkout warehouse');
                    break;
            case $url == route('admin.warehousemgt.checkout.authorize_checkout',['batch_no' => $request->batch_no ?? 0]) :
                                $proceed = $admin->can('authorize checkout');
                                break;
            default : 
                  break;
                  
        }
        //check url and if logged in user can else return to deny
        return ($proceed) ? $next($request) : redirect()->route('admin.dashboard.deny');
    }
}
