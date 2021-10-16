<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\AdminDashboardClass;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->adminDashboardClass = new AdminDashboardClass;
    }
    //
    public function Index()
    {
        $resp = $this->adminDashboardClass->dashboardData(auth('admin')->user());
        return view('dashboard.index',$resp['data']);
    }

    public function Logout()
    {
        auth('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function Deny()
    {
        return view('dashboard.deny');
    }
}
