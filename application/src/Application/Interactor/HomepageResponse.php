<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Model\ValueObject;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Class HomepageResponse
 * @package Application\Interactor
 *
 * @property-read string $capitalCity
 * @property-read \Application\Entity\ProfessionalUser[] $bigCitiesWithFeaturedProfessionals
 * @property-read \Application\Entity\ProfessionalUser[] $countiesWithFeaturedProfessionals
 * @property-read FormView $searchForm
 */
class HomepageResponse extends ValueObject
{
    public function __construct(
        $capitalCity, array $bigCitiesWithFeaturedProfessionals, array $countiesWithFeaturedProfessionals,
        FormView $searchForm
    ) {
        $this->value = [
            'capitalCity' => $capitalCity,
            'bigCitiesWithFeaturedProfessionals' => $bigCitiesWithFeaturedProfessionals,
            'countiesWithFeaturedProfessionals' => $countiesWithFeaturedProfessionals,
            'searchForm' => $searchForm,
        ];
    }
}
