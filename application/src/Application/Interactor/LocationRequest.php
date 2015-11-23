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
 * Class LocationRequest
 * @package Application\Interactor
 * @author Hargitai Dávid <div@diatigrah.hu>
 *
 * @property-read string $name
 * @property-read string $type
 * @property-read string $latitude
 * @property-read string $longitude
 * @property-read string $ip
 */
class LocationRequest extends ValueObject
{
    public function __construct($name, $type, $latitude, $longitude, $ip)
    {
        $this->value = [
            'name' => $name, 'type' => $type, 'latitude' => $latitude, 'longitude' => $longitude, 'ip' => $ip
        ];
    }

    public static function createFromArray(array $data)
    {
        $data = array_merge(
            [
                'name' => '',
                'type' => '',
                'latitude' => '',
                'longitude' => '',
                'ip' => '',
            ],
            $data
        );

        return new self($data['name'], $data['type'], $data['latitude'], $data['longitude'], $data['ip']);
    }
}
