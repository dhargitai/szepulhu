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
 * Class Location
 * @package Application\Interactor
 * @author Hargitai Dávid <div@diatigrah.hu>
 *
 * @property string type
 * @property string name
 * @property string latitude
 * @property string longitude
 */
class Location extends ValueObject
{
    const TYPE_CITY = 'city';
    const TYPE_COUNTY = 'county';
    const TYPE_COUNTRY = 'country';
}
