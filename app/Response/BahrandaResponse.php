<?php

namespace App\Response;

use App\Bahranda\Enum\ResponseCode;
use App\Bahranda\Enum\ResponseStatus;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;

trait BahrandaResponse
{

    public   function created($message,  $data, $key){
        $status = 201;
        $response = [
            'status' => $status,
            'code' => ResponseCode::CREATED_SUCCESS,
            'title' => $message,
            $key => $data
        ];
        return response($response,$status);
    }

    public  function updated($message, $data,$key){
        $status = 200;

        $response = [
            'status' => $status,
            'code' => ResponseCode::UPDATED_SUCCESS,
            'title' => $message,
            $key =>  $data
        ];

        return response($response,$status);
    }

    public  function deleted($message, $data,$key){
        $status = 200;
        $response = [
            'status' => $status,
            'code' => ResponseCode::DELETED_SUCCESS,
            'title' => $message,
            $key =>  $data
        ];
        return response($response,$status);
    }

    public  function fetch($message, $data,$key){
        $status = 200;
        
        $response = [
            'status' => $status,
            'code' => ResponseCode::FETCHED_SUCCESS,
            'title' => $message,
            $key =>  $data
        ];
        return response( $response,$status);
    }

    public  function get($message, $data,$key){
        $status = 200;
        $response = [
            'status' => $status,
            'code' => ResponseCode::FETCHED_SUCCESS,
            'title' => $message,
            $key =>  $data
        ];
        return response($response,$status);
    }

    public  function error($message, $status){
    
        $response = [
            'status' => $status,
            'code' => ResponseCode::ERROR,
            'title' => $message,
        ];
        return response($response,$status);
    }
}
