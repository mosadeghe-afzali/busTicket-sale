<?php
namespace App\Traits;

trait Response
{
    public function getErrors($error, $code,)
    {
        return response()->json([
            'error' => $error,
            'status' => $code,
        ]);
    }

    public function getMessage($message, $code, $response = null)
    {
        return response()->json([
            'message' => $message,
            'status' => $code,
            'response' => $response,
        ]);
    }
}
