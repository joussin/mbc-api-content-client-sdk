<?php

namespace MbcApiContentSdk;

use MbcApiContentSdk\Facades\ApiContentSdk;

class BootstrapSdk
{

    public function __construct()
    {
        $routes = ApiContentSdk::getRouteEntity()->all();

        dd($routes);
    }
}