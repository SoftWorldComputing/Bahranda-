<?php

namespace App\Http\Controllers\Api;

use App\Classes\UserDashboardClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    //
        public function __construct()
        {
            $this->dashboardClass = new UserDashboardClass;
        }

        public function getUserDashboardInfo(Request $request)
        {
            return  $this->dashboardClass->getUserDashboardInfo($request->user());
        }
}
