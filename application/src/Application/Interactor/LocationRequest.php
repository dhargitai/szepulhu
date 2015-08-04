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
 * @property string $name
 * @property string $type
 * @property string $latitude
 * @property string $longitude
 * @property string $ip
 */
class LocationRequest extends ValueObject
{
}
