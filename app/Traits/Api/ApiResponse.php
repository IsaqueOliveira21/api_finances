<?php

namespace App\Traits\Api;

trait ApiResponse {

    protected function successResponse(mixed $data, string $message = 'Success', int $code = 200) {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    protected function errorResponse(string $message = 'An error occurred, try again later.', int $code = 500) {
        return response()->json([
            'success' => false,
            'error' => $message,
        ], $code);
    }
}
