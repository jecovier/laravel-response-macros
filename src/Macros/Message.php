<?php

namespace Jecovier\ResponseMacros\Macros;

use Jecovier\ResponseMacros\ResponseMacroInterface;

class Message implements ResponseMacroInterface
{
    public function run($factory)
    {
        $factory->macro('message', function (string $message, $status = 200) use ($factory) {
            return $factory->make([
                'message' => $message,
            ], $status);
        });
    }
}
