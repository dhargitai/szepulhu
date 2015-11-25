<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Element\Professionals;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;


/**
 * Class ResultItem
 *
 * This element represents one or more matched professional user items.
 *
 * @package Page\Element\Professionals
 * @author Geza Buza <bghome@gmail.com>
 */
class ResultItem extends Element
{
    protected $selector = 'tr.professional';

    public function hasName()
    {
        return $this->has('css', '.professionalName');
    }

    public function hasProfession()
    {
        return $this->has('css', '.professionalProfession');
    }

    public function hasSalon()
    {
        return $this->has('css', '.professionalSalon');
    }

    public function hasPostalAddress()
    {
        return $this->has('css', '.professionalAddress');
    }

    public function hasLinkToProfile()
    {
        return $this->has('css', 'a[href^="/"]');
    }

    public function hasLinkToMap()
    {
        return $this->has('css', '.professionalAddress > a');
    }

    public function hasPhoto()
    {
        return $this->has('css', 'a > img');
    }
}