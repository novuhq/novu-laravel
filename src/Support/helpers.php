<?php

use Illuminate\Contracts\Foundation\Application;

if (!function_exists("novu")) {

    /**
     * @return Application|mixed
     */
    function novu()
    {
        return app()->make('novu');
    }
}