<?php

namespace Application\Interactor;

use Application\Model\ValueObject;

/**
 * Class FeaturedProfessionalsRequest
 * @package Application\Interactor
 *
 * @property-read Location $location
 * @property-read string $numberOfFeaturedProfessionals
 */
class FeaturedProfessionalsRequest extends ValueObject
{
    public function __construct(Location $location, $numberOfFeaturedProfessionals)
    {
        $this->value = [
            'location' => $location,
            'numberOfFeaturedProfessionals' => $numberOfFeaturedProfessionals
        ];
    }
}
