<?php

namespace Application\Interactor;

use Application\Model\ValueObject;

/**
 * Class FeaturedProfessionalsRequest
 * @package Application\Interactor
 *
 * @property-read LocationRequest $locationRequest
 * @property-read string $numberOfFeaturedProfessionals
 */
class FeaturedProfessionalsRequest extends ValueObject
{
    public function __construct(LocationRequest $locationRequest, $numberOfFeaturedProfessionals)
    {
        $this->value = [
            'locationRequest' => $locationRequest,
            'numberOfFeaturedProfessionals' => $numberOfFeaturedProfessionals
        ];
    }
}
