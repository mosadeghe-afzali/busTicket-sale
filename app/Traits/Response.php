<?php
namespace App\Traits;

trait Response
{
    /**
     * @param string $error
     * @param int $code
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function getErrors($error, $code,)
    {
        return response()->json([
            'error' => $error,
            'status' => $code,
        ]);
    }

    /**
     * @param string $message
     * @param int $code
     * @param null $response
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function getMessage($message, $code = 200, $response = null)
    {
        return response()->json([
            'message' => $message,
            'status' => $code,
            'response' => $response,
        ]);
    }
}
