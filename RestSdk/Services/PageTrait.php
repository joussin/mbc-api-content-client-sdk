<?php

namespace SdkRestApi\RestSdk\Services;

use SdkRestApi\RestSdk\Entity\EntityCollection;
use SdkRestApi\RestSdk\Entity\EntityInterface;

use SdkRestApi\RestSdk\Entity\Page\Page;

Trait PageTrait
{
    public function getAllPages() : EntityCollection
    {
        $result = $this->restClientService->request(
            'GET',
            '/api/page',
            [],
            true,
            Page::class
        );

        return $result;
    }

    public function getPage($id) : EntityInterface
    {
        $result = $this->restClientService->request(
            'GET',
            '/api/page/' . $id,
            [],
            false,
            Page::class
        );

        return $result;
    }

    public function updatePage($id, array $attributes) : EntityCollection
    {
        $result = $this->restClientService->request(
            'PUT',
            '/api/page/' . $id,
            [
                'json' => $attributes
            ],
            false,
            Page::class
        );

        return $result;
    }


    public function createPage(array $attributes) : EntityCollection
    {
        $result = $this->restClientService->request(
            'POST',
            '/api/page',
            [
                'json' => $attributes
            ],
            false,
            Page::class
        );

        return $result;
    }



}
