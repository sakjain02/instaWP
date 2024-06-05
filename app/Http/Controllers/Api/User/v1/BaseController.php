<?php

namespace App\Http\Controllers\Api\User\v1;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

     public function sendResponse($result, $message, $extradata = [], $status = 200)
     {
         $response = [
            'success' => true,
            'status' => $status,
            'data' => $result,
            'message' => $message,
         ];
 
         $response = array_merge($response, $extradata);
         return response()->json($response, 200);
     }
 
     /**
      * return error response.
      *
      * @return \Illuminate\Http\Response
      */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'status' => $code,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}