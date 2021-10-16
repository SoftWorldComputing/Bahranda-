<?php

namespace App\Http\Controllers\Api;

use App\Classes\FrontEndClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function __construct()
    {
        $this->frontendClass = new FrontEndClass;
    }

    public function getAllTeamMembers(Request $request)
    {
        return $this->frontendClass->getAllTeamMembers();
    }
    public function getAllFaqs(Request $request)
    {
        return $this->frontendClass->getAllFaqs();
    }

    public function getReviews(Request $request)
    {
        return $this->frontendClass->getReviews();
    }

    public function getPrivacy(Request $request)
    {
        return $this->frontendClass->getPrivacy();
    }


    public function getTerms(Request $request)
    {
        return $this->frontendClass->getTerms();
    }
    

    public function contactUs(Request $request)
    {
        $this->validate($request,[
            "name" => "required",
            "phone" => "required",
            "email" => "required|email",
            "message" => "required",
        ]);

        $data = $request->only(['name','phone','email','message']);

        return $this->frontendClass->contactUs($data);

    }
    

    public function subscribeUser(Request $request)
    {
        $this->validate($request,[
            "name" => "required",
            "email" => "required|email",
          
        ]);

        $data = $request->only(['name','email']);

        return $this->frontendClass->subscribeUser($data);

    }

    public function getCommodities(Request $request)
    {
        return $this->frontendClass->getCommodities();
    }
    
}
