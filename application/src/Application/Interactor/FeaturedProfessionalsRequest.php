<?php

namespace Application\Interactor;

class FeaturedProfessionalsRequest
{
    public $county;
    public $city;

    public function __construct(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
}
