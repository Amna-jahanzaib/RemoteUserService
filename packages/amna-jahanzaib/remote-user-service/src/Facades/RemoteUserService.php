<?php

namespace AmnaJahanzaib\RemoteUserService\Facades;

use Illuminate\Support\Facades\Facade;

class RemoteUserService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'remote-user-service';
    }
}
