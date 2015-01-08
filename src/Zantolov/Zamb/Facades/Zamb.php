<?php

namespace Zantolov\Zamb\Facades;

use Illuminate\Support\Facades\Facade;

class Zamb extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'zamb';
    }
} 