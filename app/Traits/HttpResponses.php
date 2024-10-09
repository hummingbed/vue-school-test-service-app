<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponses
{
    protected function successHttpMessage($message, $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], $code);
    }

    protected function errorHttpMessage($data, $code = 400, $message = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}