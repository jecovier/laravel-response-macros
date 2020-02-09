<?php

namespace Jecovier\ResponseMacros;

use Jecovier\ResponseMacros\Exceptions\CustomHandler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;

class ResponseMacrosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            //
        }

        $this->app->bind(
            ExceptionHandler::class,
            CustomHandler::class
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->make('Jecovier\ResponseMacros\ResponseMacros');
    }
}
