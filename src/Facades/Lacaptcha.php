<?php

namespace CrazyInventor\Lacaptcha\Facades;

use Illuminate\Support\Facades\Facade;

class Lacaptcha extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'recaptcha';
    }
}