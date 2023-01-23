<?php

namespace SdkRestApi\RestSdk\Services;

use SdkRestApi\RestSdk\Entity\EntityCollection;
use SdkRestApi\RestSdk\Entity\EntityInterface;
use SdkRestApi\RestSdk\Entity\Template\Template;

trait TemplateTrait
{
    public function getAllTemplates() : EntityCollection
    {
        $result = $this->restClientService->request(
            'GET',
            '/api/template',
            [],
            true,
            Template::class
        );

        return $result;
    }

    public function getTemplate($id) : EntityInterface
    {
        $result = $this->restClientService->request(
            'GET',
            '/api/template/' . $id,
            [],
            false,
            Template::class
        );

        return $result;
    }

    public function updateTemplate($id, array $attributes) : EntityCollection
    {
        $result = $this->restClientService->request(
            'PUT',
            '/api/template/' . $id,
            [
                'json' => $attributes
            ],
            false,
            Template::class
        );

        return $result;
    }


    public function createTemplate(array $attributes) : EntityCollection
    {
        $result = $this->restClientService->request(
            'POST',
            '/api/template',
            [
                'json' => $attributes
            ],
            false,
            Template::class
        );

        return $result;
    }

}
