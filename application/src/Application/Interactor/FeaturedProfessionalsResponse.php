<?php

namespace Application\Interactor;

class FeaturedProfessionalsResponse
{
    public function __construct(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->$name = $value;
        }
    }
}
