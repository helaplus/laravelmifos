<?php

namespace Helaplus\Laravelmifos\Facades;

use Illuminate\Support\Facades\Facade;

class Laravelmifos extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelmifos';
    }
}
