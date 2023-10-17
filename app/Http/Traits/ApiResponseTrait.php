<?php


namespace App\Http\Responses;

trait ApiResponseTrait
{
    
    public function successResponse($data = null, $statusCode = 200)
    {
        return response()->json(['data' => $data, 'success' => true], $statusCode);
    }

    public function errorResponse($message, $statusCode)
    {
        return response()->json(['error' => $message, 'success' => false], $statusCode);
    }
}