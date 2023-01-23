<?php

namespace SdkRestApi\RestSdk\Services;

use SdkRestApi\RestSdk\Entity\EntityCollection;
use SdkRestApi\RestSdk\Entity\EntityInterface;

use SdkRestApi\RestSdk\Entity\Route\Route;

Trait RouteTrait
{
    public function getAllRoutes() : EntityCollection
    {
        $result = $this->restClientService->request(
            'GET',
            '/api/route',
            [],
            true,
            Route::class
        );

        return $result;
    }

    public function getRoute($id) : EntityInterface
    {
        $result = $this->restClientService->request(
            'GET',
            '/api/route/' . $id,
            [],
            false,
            Route::class
        );

        return $result;
    }

    public function updateRoute($id, array $attributes) : EntityCollection
    {
        $result = $this->restClientService->request(
            'PUT',
            '/api/route/' . $id,
            [
                'json' => $attributes
            ],
            false,
            Route::class
        );

        return $result;
    }


    public function createRoute(array $attributes) : EntityCollection
    {
        $result = $this->restClientService->request(
            'POST',
            '/api/route',
            [
                'json' => $attributes
            ],
            false,
            route::class
        );

        return $result;
    }



}
