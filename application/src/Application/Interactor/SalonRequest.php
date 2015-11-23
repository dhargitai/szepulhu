<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.28.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;
use Application\Model\ValueObject;

/**
 * Class SalonRequest
 * @package Application\Interactor
 *
 * @property-read string $slug
 */
class SalonRequest extends ValueObject
{
    public function __construct($slug)
    {
        $this->value['slug'] = $slug;
    }
}
