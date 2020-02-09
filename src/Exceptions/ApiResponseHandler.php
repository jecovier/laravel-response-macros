<?php

namespace Jecovier\ResponseMacros\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use App\Exceptions\Handler as ExceptionHandler;

class ApiResponseHandler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (
            !$request->expectsJson()
            || empty($this->formatApiResponse)
            || !$this->formatApiResponse
        ) {
            return parent::render($request, $exception);
        }
        return response()->error(
            $exception->getMessage(),
            $this->getStatus($exception),
            $this->getErrors($exception)
        );
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if (
            $request->expectsJson()
            && !empty($this->formatApiResponse)
            && $this->formatApiResponse
        ) {
            return response()->error(
                'Unauthenticated.',
                401,
                getenv('APP_DEBUG') == 'true' ? $exception : null
            );
        }
        return parent::unauthenticated($request, $exception);
    }

    /**
     * Get the status code of the Exception
     * 
     * @param  \Exception  $exception
     * @return Mixed
     */
    private function getStatus(Exception $exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            return $exception->getStatusCode();
        }

        return ($exception->getCode() && $exception->getCode() >= 100 && $exception->getCode() <= 522)
            ? $exception->getCode()
            : 500;
    }

    /**
     * Get the errors bag of the Exception, if no errors is and the APP_DEBUG is
     * true, the $exception itself is returned
     * 
     * @param  \Exception  $exception
     * @return Array
     */
    private function getErrors(Exception $exception)
    {
        if (!empty($exception->errors))
            return $exception->errors;
        if (getenv('APP_DEBUG') == 'true')
            return $exception;
        return null;
    }
}
