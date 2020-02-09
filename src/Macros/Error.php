<?php

namespace Jecovier\ResponseMacros\Macros;

use Jecovier\ResponseMacros\ResponseMacroInterface;

class Error implements ResponseMacroInterface
{
    public function run($factory)
    {
        $factory->macro('error', function (string $message = 'Bad Request', $status = 400, $errors = []) use ($factory) {
            return $factory->make([
                "message" => $message,
                "status" => $status,
                "success" => false,
                "data" => null,
                "errors" => $errors,
            ], $status);
        });
    }
}
