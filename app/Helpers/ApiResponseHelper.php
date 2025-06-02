<?php

namespace App\Helpers;

class ApiResponseHelper
{
    public static function success($data = null, $message = "Operación exitosa",$status=200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ] ,$status);
    }

    public static function error($message = "Error en la operación", $status = 400,$error = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' =>$error
        ], $status);
    }
}