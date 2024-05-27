<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data, $message = 'Success', $status = 200)
    {
        return response()->json([
            'data' => $data,
            'status' => $status,
            'message' => $message
        ], $status);
    }

    public static function error($message, $status = 400, $data = null)
    {
        return response()->json([
            'data' => $data,
            'status' => $status,
            'message' => $message
        ], $status);
    }
}
