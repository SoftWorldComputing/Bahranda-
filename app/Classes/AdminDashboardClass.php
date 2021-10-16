<?php
namespace App\Classes;
use App\Models\Partnership;

class AdminDashboardClass {

    public function __construct()
    {
    
    }
    public function dashboardData($admin)
    {
        //d
        if($admin->can('view dashboard'))
        {
            $daily_deals_amt = Partnership::whereBetween('created_at',[date('Y-m-d 00:00:00',strtotime('now')),date('Y-m-d 23:59:59',strtotime('now'))])->sum('amount');

            $daily_deals_no = Partnership::whereBetween('created_at',[date('Y-m-d 00:00:00',strtotime('now')),date('Y-m-d 23:59:59',strtotime('now'))])->count();
    
            $monthly_deals_amt = Partnership::whereBetween('created_at',[date('Y-m-01 00:00:00',strtotime('now')),date('Y-m-30 23:59:59',strtotime('now'))])->sum('amount');
    
            $monthly_deals_no = Partnership::whereBetween('created_at',[date('Y-m-01 00:00:00',strtotime('now')),date('Y-m-30 23:59:59',strtotime('now'))])->count();
    
            $total_revenue = Partnership::sum('profit');
            $no_of_deals = Partnership::whereStatus(4)->count();
    
            $deals = Partnership::get()->take(10);
    
            return ["status" => "success","message" => "Dashboard fetched successfully","data" => compact('daily_deals_amt','daily_deals_no','monthly_deals_amt','monthly_deals_no','total_revenue','no_of_deals','deals')];
        }else{
            return ["status" => "success","message" => "Dashboard fetched successfully","data" => ['logs' => []]];
        }
       

        
    }
}