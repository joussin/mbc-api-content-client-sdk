<?php

namespace MbcApiContentSdk\Facades;


use Illuminate\Support\Facades\Facade;


/**
 *
 * @see \MbcApiContentSdk\Services\RouterService;
 */
class RouterFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'router_service_facade_accessor';
    }
}