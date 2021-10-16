<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class BaseController extends Controller
{

    public $admin;

    public function __construct()
    {
       
        $this->middleware(function ($request, $next) {
            $this->admin = auth('admin')->user();
        
            return $next($request);

        });
    }
}