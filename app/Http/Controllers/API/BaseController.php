<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function send_Response($result){

        $response = [
            'success' => true,
            'data'    =>$result,
        ];
        return $response;

    }

    public function sendError($error,$errorMessage=[]){

        $response = [
            'success' => false,
            'data'    => $error,
        ];

        if(!empty($errorMessage)){
            $response['data'] = $errorMessage;
        }

        return response()->json($response,404);
    }
}
