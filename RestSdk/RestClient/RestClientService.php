<?php

namespace SdkRestApi\RestSdk\RestClient;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use SdkRestApi\RestSdk\Entity\Entity;
use SdkRestApi\RestSdk\Entity\EntityCollection;
use SdkRestApi\RestSdk\Entity\EntityInterface;


class RestClientService implements RestClientServiceInterface
{
    protected ClientInterface $client;


    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function renderHttpClientResponse(ResponseInterface $response) : ?array
    {
        $result = $response->getBody()->getContents();

        return json_decode($result, true);
    }

    public function renderEntity($entity, array $result, bool $collection = false) : EntityInterface|EntityCollection
    {
        $resultAsEntity = null;

        if($collection)
        {
            $entityArray = [];

            foreach ($result as $resultOne)
            {
                $resultAsEntityOne = new $entity($resultOne);
                $entityArray[] = ($resultAsEntityOne);
            }
            $resultAsEntity = new EntityCollection($entityArray);
        }
        else {
            $resultAsEntity = new $entity($result);
        }
        return $resultAsEntity;
    }


    public function request(string $method, string $url, array $options = [], bool $collection = false, string $entity) : EntityInterface|EntityCollection
    {
        $response = $this->client->request($method, $url, $options);

        $result = $this->renderHttpClientResponse($response);

        $resultEntity = $this->renderEntity($entity, $result, $collection);


        return $resultEntity;
    }

}
