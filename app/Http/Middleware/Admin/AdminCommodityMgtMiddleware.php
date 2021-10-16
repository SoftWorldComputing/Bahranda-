<?php

namespace App\Http\Middleware\Admin;

use Closure;

class AdminCommodityMgtMiddleware
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

                switch (true) {
                        case $url == route('admin.productmgt.list'):
                                $proceed = $admin->can('list commodity');
                                break;
                        case $url == route('admin.productmgt.store.view'):
                                $proceed = $admin->can('add commodity');
                                break;
                        case $url == route('admin.productmgt.store'):
                                $proceed = $admin->can('add commodity');
                                break;
                        case $url == route('admin.productmgt.show', ['product' => $request->product ?? 0]):
                                $proceed = $admin->can('show commodity');
                                break;
                        case $url == route('admin.productmgt.edit.view', ['product' => $request->product ?? 0]):
                                $proceed = $admin->can('edit commodity');
                                break;
                        case $url == route('admin.productmgt.edit', ['product' => $request->admin ?? 0]):
                                $proceed = $admin->can('edit commodity');
                                break;
                        case $url == route('admin.commodity_price.list'):
                                $proceed = $admin->can('commodity price');
                                break;
                        case $url == route('admin.commodity_price.list.update.view'):
                                $proceed = $admin->can('commodity price');
                                break;
                        case $url == route('admin.commodity_price.list.update.format'):
                                $proceed = $admin->can('commodity price');
                                break;
                        case $url == route('admin.commodity.add_new_batch', ['commodity' => $request->commodity ?? 0]):
                                $proceed = $admin->can('add new batch');
                                break;
                        case $url == route('admin.commodity.change_batch', ['commodity' => $request->commodity ?? 0]):
                                $proceed = $admin->can('change batch');
                                break;
                        case $url == route('admin.commodity.batch_history', ['batch' => $request->batch ?? 0, 'commodity' => $request->commodity ?? 0]):
                                $proceed = $admin->can('view batch history');
                                break;
                        case $url == route('admin.commodity_price.price_upload.batch'):
                                $proceed = $admin->can('commodity price');
                                break;
                        case $url == route('admin.commodity_price.price_upload.batch.data', ['batch_no' => $request->batch_no ?? 0]):
                                $proceed = $admin->can('commodity price');
                                break;

                        case $url == route('admin.commodity_price.list.update.authorize', ['batch_no' => $request->batch_no ?? 0]):
                                $proceed = $admin->can('authorize price upload');
                                break;

                        case $url == route('admin.productmgt.delete', ['commodity' => $request->commodity ?? 0]):
                                $proceed = $admin->can('authorize price upload');
                                break;
                        
                        case $url == route('admin.commodity_price.purchase_for_user', ['commodity' => $request->commodity ?? 0]):
                                $proceed = $admin->can('show commodity');
                                break;

                        case $url == route('admin.commodity_price.purchase_for_user.fetch_user_balance', ['user' => $request->user ?? 0]):
                                $proceed = $admin->can('show commodity');
                                break;
                        case $url == route('admin.commodity_price.purchase_for_user.commodity_price', ['commodity' => $request->commodity ?? 0,'quantity' => $request->quantity ?? 0]):
                                $proceed = $admin->can('show commodity');
                                break;

                        case $url == route('admin.commodity_price.purchase_for_user.store', ['commodity' => $request->commodity ?? 0]):
                                $proceed = $admin->can('show commodity');
                                break;
                               
                        default:
                                break;
                }
                //check url and if logged in user can else return to deny
                return ($proceed) ? $next($request) : redirect()->route('admin.dashboard.deny');
        }
}
