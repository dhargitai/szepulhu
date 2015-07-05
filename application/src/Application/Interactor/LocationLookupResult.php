<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.06.07.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Model\ValueObject;

/**
 * Class LocationLookupResult
 *
 * @package Application\Interactor
 *
 * @property string ip
 * @property string country
 * @property string region
 * @property string city
 */
class LocationLookupResult extends ValueObject
{
}
