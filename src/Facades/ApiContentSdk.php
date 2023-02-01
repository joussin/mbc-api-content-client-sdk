<?php

namespace MbcApiContentSdk\Facades;


use Illuminate\Support\Facades\Facade;

/**
 *
 * @see \MbcApiContentSdk\Services\ApiSdkService;
 */
class ApiContentSdk extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sdk_service_facade_accessor';
    }
}
