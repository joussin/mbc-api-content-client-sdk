<?php

namespace MbcApiContentSdk\Entity\Entity;

use MbcApiContentSdk\RestClient\RestClientInterface;

abstract class AbstractEntity implements EntityInterface
{

    protected RestClientInterface $restClient;

    public function __construct(RestClientInterface $restClient)
    {
        $this->restClient = $restClient;
    }

    /**
     * @return string
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    public function search(string $column, string $column_value, bool $relations = false) : ?array
    {
        return $this->restClient->search(
            $this->getResource(),
            $column,
            $column_value,
            $relations,
        );
    }

    public function all()
    {
        return $this->restClient->all($this->getResource());
    }

    public function get(int $id) : ?array
    {
        return $this->restClient->get($this->getResource(), $id);
    }


    public function put(int $id, array $attributes) : ?array
    {
        return $this->restClient->put($this->getResource(), $id, $attributes);
    }

    public function post(array $attributes) : ?array
    {
        return $this->restClient->post($this->getResource(), $attributes);
    }


    public function delete(int $id) : ?array
    {
        return $this->restClient->delete($this->getResource(), $id);
    }

}
