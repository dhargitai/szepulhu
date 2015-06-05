<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Model\ValueObject;

/**
 * Class HomepageResponse
 * @package Application\Interactor
 *
 * @property string $capitalCity
 * @property \Application\Entity\ProfessionalUser[] $bigCitiesWithFeaturedProfessionals
 * @property \Application\Entity\ProfessionalUser[] $countiesWithFeaturedProfessionals
 */
class HomepageResponse extends ValueObject
{
}
