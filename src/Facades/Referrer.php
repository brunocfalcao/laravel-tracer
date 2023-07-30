<?php

namespace Brunocfalcao\Tracer\Facades;

use Illuminate\Support\Facades\Facade;

class Referrer extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'tracer-referrer';
    }
}
