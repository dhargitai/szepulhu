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
 * @property-read string $picture
 * @property-read string $name
 * @property-read string $address
 * @property-read string $addressAdditional
 * @property-read string $city
 * @property-read string $postCode
 * @property-read string $phone
 * @property-read string $mapUrl
 * @property-read string $map
 * @property-read \Application\Entity\ProfessionalUser[] $professionals
 */
class SalonResponse extends ValueObject
{
    public function __construct(
        $picture, $name, $address, $addressAdditional, $city, $postCode, $phone, $mapUrl, $map, $professionals
    ) {
        $this->value = [
            'picture' => $picture, 'name' => $name, 'address' => $address, 'addressAdditional' => $addressAdditional,
            'city' => $city, 'postCode' => $postCode, 'phone' => $phone, 'mapUrl' => $mapUrl, 'map' => $map,
            'professionals' => $professionals
        ];
    }
}
