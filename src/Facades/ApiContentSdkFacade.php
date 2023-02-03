<?php

namespace MbcApiContentSdk\Facades;


use Illuminate\Support\Facades\Facade;


/**
 *
 * @see \MbcApiContentSdk\ApplicationApiContentSdkInterface;
 */
class ApiContentSdkFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'api_content_sdk_facade_accessor';
    }
}
