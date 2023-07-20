<?php

namespace Novu\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Novu
 * @package Novu\Laravel\Facades
 */
class Novu extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'novu';
    }
}
