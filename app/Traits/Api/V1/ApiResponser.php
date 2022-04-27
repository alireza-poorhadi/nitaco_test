<?php

namespace App\Traits\Api\V1;

trait ApiResponser
{
    protected function successResponse($data, $code = 200, $message = '')
    {
        return response()->json([
            'status' => 'OK',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($code, $message = '', $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}