<?php

namespace SdkRestApi\RestSdk\RestClient;

use Psr\Http\Message\ResponseInterface;
use SdkRestApi\RestSdk\Entity\EntityCollection;
use SdkRestApi\RestSdk\Entity\EntityInterface;

interface RestClientServiceInterface
{

    public function renderHttpClientResponse(ResponseInterface $response) : ?array;

    public function request(string $method, string $url, array $options = [], bool $collection = false, string $entity) : EntityInterface|EntityCollection;

}
