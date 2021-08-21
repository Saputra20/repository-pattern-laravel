<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($message = "", $data = "")
    {
        return response()->json([
            "status" => true,
            "message" => $message,
            "data" => $data
        ], 200);
    }

    public static function error($message = "", $code = 422 , $data = "")
    {
        return response()->json([
            "status" => false,
            "message" => $message,
            "data" => $data,
            "error_code" => $code
        ], $code);
    }
}
