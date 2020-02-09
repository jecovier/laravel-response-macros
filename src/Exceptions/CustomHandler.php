<?php

namespace Jecovier\ResponseMacros\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use App\Exceptions\Handler as ExceptionHandler;

class CustomHandler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->expectsJson()) {
            return response()->error(
                $exception->getMessage(),
                $this->getStatus($exception),
                $this->getErrors($exception)
            );
        }
        return parent::render($request, $exception);
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
        if ($request->expectsJson()) {
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
        return method_exists($exception, 'getStatusCode')
            ? $exception->getStatusCode()
            : $exception->getCode();
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
