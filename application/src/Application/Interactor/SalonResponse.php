<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.28.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Model\ValueObject;

/**
 * Class SalonResponse
 * @package Application\Interactor
 *
 * @property string $picture
 * @property string $name
 * @property string $address
 * @property string $addressAdditional
 * @property string $city
 * @property string $postCode
 * @property string $phone
 * @property string $mapUrl
 * @property string $map
 * @property \Application\Entity\ProfessionalUser[] $professionals
 */
class SalonResponse extends ValueObject
{
}
