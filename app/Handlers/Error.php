<?php

namespace App\Handlers;

use \Exception;
use Illuminate\Support\Facades\Log;

class Error{

    public static function Handle(Exception $error, String $controllerCode, $http_code = 200){
        
        $log = [
            'error' => $error->getMessage(),
            'error_code' => $error->getCode(),
            'file' => $error->getFile(),
            'line' => $error->getLine(),
        ];

        Log::error($log);

        $error_log = [
            'status' => false,
            'error' => $error->getMessage()
        ];

        if($error->getCode() == 1){
            $error_log['error'] = json_decode($error->getMessage());
        }

        return response()->json($error_log);
    }
}