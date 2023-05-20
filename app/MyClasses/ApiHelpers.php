<?php

namespace App\MyClasses;

use Illuminate\Http\Response;

class ApiHelpers {

    /**
     * @param string $message
     * @param array $payload
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public static function response(string $message, array $payload = [], int $status = Response::HTTP_OK) {
        return response()->json(['message' => $message, 'payload' => $payload, 'datetime' => now()->toDateTimeString(),], $status);
    }
}
