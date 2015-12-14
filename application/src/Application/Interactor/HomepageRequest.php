<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Model\ValueObject;

/**
 * Class HomepageRequest
 *
 * @package Application\Interactor
 *
 * @property-read string $searchParameters
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class HomepageRequest extends ValueObject
{
    public function __construct($searchParameters = '')
    {
        $this->value['searchParameters'] = $searchParameters;
    }
}
