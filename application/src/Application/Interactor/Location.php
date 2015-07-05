<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.06.06.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Model\ValueObject;

/**
 * Class Location
 * @package Application\Interactor
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
