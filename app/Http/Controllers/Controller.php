<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Use this method for success api response
    protected function successResponse($message = '', $code = 200, $data = []){
        return response()->json([
            'message' => $message,
            'code' => $code,
            'data' =>$data
        ]);
    }

    // Use this method for fail api response
    protected function failResponse($message = '', $code = 400, $data = []){
        return response()->json([
            'message' => $$message,
            'code' => $code,
            'data' =>$data
        ]);
    }
}
