<?php

namespace MbcApiContentSdk\RestClient;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;


class RestClient implements RestClientInterface
{
    
    protected string $prefix;

    protected ClientInterface $client;

    public function __construct(ClientInterface $client, string $prefix = '/api/v1/')
    {
        $this->client = $client;
        $this->prefix = $prefix;
    }

    public function response(ResponseInterface $response) : ?array
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    public function request(string $method, string $url, array $options = []) : ?array
    {
        $response = $this->client->request($method, $url, $options);
        return $this->response($response);
    }

    public function search(string $resource, string $column, string $column_value, bool $relations = false) : ?array
    {
        $relations = $relations ? '&relations=true' : '';
        return $this->request('GET', $this->prefix . "/$resource/search?column=$column&column_value=$column_value" . $relations, []);
    }

    public function all(string $resource) : ?array
    {
        return $this->request('GET', $this->prefix . "/$resource/", []);
    }

    public function get(string $resource, int $id) : ?array
    {
        return $this->request('GET', $this->prefix . "/$resource/" . $id, []);
    }

    public function put(string $resource, int $id, array $attributes) : ?array
    {
        return $this->request('PUT', $this->prefix . "/$resource/" . $id, ['json' => $attributes]);
    }


    public function post(string $resource, array $attributes) : ?array
    {
        return $this->request('POST',$this->prefix . "/$resource/", ['json' => $attributes]);
    }

    public function delete(string $resource, int $id) : ?array
    {
        return $this->request('DELETE', $this->prefix . "/$resource/" . $id, []);
    }

}
