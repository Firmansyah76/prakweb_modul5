<?php

namespace prak5web\Traits;

trait ApiResponseFormatter
{
    public function apiResponse($code = 200, $message = "success", $data = [])
    {
        return json_encode([
            "code" => $code,
            "message" => $message,
            "data" => $data
        ]);
    }
}
?>