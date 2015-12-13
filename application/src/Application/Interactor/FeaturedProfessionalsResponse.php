<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Interactor;

use Application\Model\ValueObject;

/**
 * Class FeaturedProfessionalsResponse
 * @package Application\Interactor
 *
 * @property-read array $featuredProfessionals
 * @property-read int $numberOfFeaturedProfessionals
 * @property-read Location $location
 * @property-read \Application\Entity\ProfessionalUser[] $bigCitiesWithFeaturedProfessionals
 * @property-read \Application\Entity\ProfessionalUser[] $countiesWithFeaturedProfessionals
 */
class FeaturedProfessionalsResponse extends ValueObject
{
    public function __construct(
        array $featuredProfessionals, $numberOfFeaturedProfessionals, Location $location,
        array $bigCitiesWithFeaturedProfessionals, array $countiesWithFeaturedProfessionals
    ) {
        $this->value = [
            'featuredProfessionals' => $featuredProfessionals,
            'numberOfFeaturedProfessionals' => $numberOfFeaturedProfessionals,
            'location' => $location,
            'bigCitiesWithFeaturedProfessionals' => $bigCitiesWithFeaturedProfessionals,
            'countiesWithFeaturedProfessionals' => $countiesWithFeaturedProfessionals,
        ];
    }
}
