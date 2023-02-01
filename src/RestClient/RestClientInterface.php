<?php

namespace MbcApiContentSdk\RestClient;

use Psr\Http\Message\ResponseInterface;

interface RestClientInterface
{
    public function response(ResponseInterface $response): ?array;

    public function request(string $method, string $url, array $options = []): ?array;

    public function search(string $resource, string $column, string $column_value, bool $relations = false): ?array;

    public function all(string $resource): ?array;

    public function get(string $resource, int $id): ?array;

    public function put(string $resource, int $id, array $attributes): ?array;

    public function post(string $resource, array $attributes): ?array;

    public function delete(string $resource, int $id): ?array;
}
