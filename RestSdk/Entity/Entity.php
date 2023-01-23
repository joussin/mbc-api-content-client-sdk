<?php

namespace SdkRestApi\RestSdk\Entity;

class Entity implements EntityInterface
{

    public function __construct($result)
    {
        $this->hydrate($result);
    }


    public function hydrate($result)
    {
        foreach ($result as $prop => $value)
        {
            $this->$prop = $value;
        }

    }

}
