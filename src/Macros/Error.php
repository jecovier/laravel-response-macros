<?php

namespace Jecovier\ResponseMacros\Macros;

use Jecovier\ResponseMacros\ResponseMacroInterface;

class Error implements ResponseMacroInterface
{
    public function run($factory)
    {
        $factory->macro('error', function (string $message = 'Bad Request', string $status = '400', $errors = []) use ($factory) {

            $numeric_status = intval($status);
            $http_status = $numeric_status >= 100 && $numeric_status <= 521 ? $numeric_status : 500;

            return $factory->make([
                "message" => $message,
                "status" => $status,
                "success" => false,
                "data" => null,
                "errors" => $errors,
            ], $http_status);
        });
    }
}
