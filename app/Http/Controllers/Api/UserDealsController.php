<?php

namespace App\Http\Controllers\Api;

use App\Classes\UserDealsClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDealsController extends Controller
{
    //
    public function __construct()
    {
        $this->userDealClass = new UserDealsClass;
    }

    public function fetchAllDeals(Request $request)
    {
        return $this->userDealClass->fetchAllDeals($request->user());
    }

    public function getSingleDeal(Request $request)
    {
        
        return $this->userDealClass->getSingleDeal($request->user(),$request->deal);
    }
}
