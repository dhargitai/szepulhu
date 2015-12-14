<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Model\ValueObject;

/**
 * Class ProfessionalProfileRequest
 * @package Application\Interactor
 *
 * @property-read string $slug
 */
class ProfessionalProfileRequest extends ValueObject
{
    public function __construct($slug)
    {
        $this->value['slug'] = $slug;
    }
}
