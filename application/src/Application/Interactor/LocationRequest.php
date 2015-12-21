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
 * @property-read string $latitude
 * @property-read string $longitude
 * @property-read string $ip
 */
class LocationRequest extends ValueObject
{
    public function __construct($latitude, $longitude, $ip)
    {
        $this->value = [
            'latitude' => $latitude, 'longitude' => $longitude, 'ip' => $ip
        ];
    }

    public static function createFromArray(array $data)
    {
        $data = array_merge(
            [
                'latitude' => '',
                'longitude' => '',
                'ip' => '',
            ],
            $data
        );

        return new self($data['latitude'], $data['longitude'], $data['ip']);
    }
}
