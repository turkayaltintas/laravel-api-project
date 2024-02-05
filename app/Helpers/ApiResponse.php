<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function send(int $code, $data = null, string $message = null, $errors = null): JsonResponse
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
        ];

        return response()->json($response, $code);
    }
}
