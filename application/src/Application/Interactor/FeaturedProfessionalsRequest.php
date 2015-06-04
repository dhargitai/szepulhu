<?php

namespace Application\Interactor;

use Application\Model\ValueObject;

class FeaturedProfessionalsRequest extends ValueObject
{
    /**
     * @return string
     */
    public function getCounty()
    {
        return $this->value['county'];
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->value['city'];
    }

    /**
     * @return int
     */
    public function getNumberOfFeaturedProfessionals()
    {
        return $this->value['numberOfFeaturedProfessionals'];
    }
}
