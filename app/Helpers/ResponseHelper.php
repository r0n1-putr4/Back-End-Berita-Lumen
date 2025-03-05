<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function successResponse($succes=true, $message, $data = null)
    {
        return response()->json([
            'success' => $succes,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public static function errorResponse($message, $status = 200)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $status);
    }   
}