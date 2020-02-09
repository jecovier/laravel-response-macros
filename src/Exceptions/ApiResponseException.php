<?php

namespace Jecovier\ResponseMacros\Exceptions;

use Exception;

class ApiResponseException extends Exception
{
    public $errors;

    /**
     * Set the errors property, an array to send in the
     * response object
     * 
     * @param array $errors
     * @return Jecovier\ResponseMacros\Exceptions\ApiResponseException
     */
    public function withErrors(array $errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->error($this->getMessage(), $this->getStatus(), $this->errors);
    }


    /**
     * Get the status code of the Exception
     * 
     * @param  \Exception  $exception
     * @return Mixed
     */
    private function getStatus()
    {
        return ($this->getCode() && $this->getCode() >= 100 && $this->getCode() <= 522)
            ? $this->getCode()
            : 500;
    }
}
