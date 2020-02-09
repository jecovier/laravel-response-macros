<?php

namespace Appstract\ResponseMacros\Macros;

use Appstract\ResponseMacros\ResponseMacroInterface;

class Success implements ResponseMacroInterface
{
    public function run($factory)
    {
        $factory->macro('success', function (string $message = 'Success', $data = [], $status = 200) use ($factory) {
            return $factory->make([
                "message" => $message,
                "status" => $status,
                "success" => true,
                "data" => $data,
                'errors' => null,
            ], $status);
        });
    }
}
