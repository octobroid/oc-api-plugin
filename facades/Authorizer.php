<?php namespace Octobro\API\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This is the authorizer facade class.
 *
 * @see \Octobro\API\Classes\Authorizer
 *

 */
class Authorizer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'oauth2-server.authorizer';
    }
}
