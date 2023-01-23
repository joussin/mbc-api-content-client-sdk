<?php

namespace SdkRestApi\RestSdk\Services;

use SdkRestApi\RestSdk\RestClient\RestClientServiceInterface;


class SdkService implements SdkServiceInterface
{
    use PageTrait;

    use RouteTrait;

    use TemplateTrait;

    protected $restClientService;


    public function __construct(RestClientServiceInterface $restClientService)
    {
        $this->restClientService = $restClientService;
    }

    public function getRestClientService(): RestClientServiceInterface
    {
        return $this->restClientService;
    }

}
