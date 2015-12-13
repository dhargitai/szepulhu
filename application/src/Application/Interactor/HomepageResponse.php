<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Model\ValueObject;
use Symfony\Component\Form\FormView;

/**
 * Class HomepageResponse
 * @package Application\Interactor
 *
 * @property-read FormView $searchForm
 */
class HomepageResponse extends ValueObject
{
    public function __construct(FormView $searchForm) {
        $this->value = ['searchForm' => $searchForm];
    }
}
