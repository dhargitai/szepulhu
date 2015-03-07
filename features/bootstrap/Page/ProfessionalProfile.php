<?php
/**
 * Created by PhpStorm.
 * User: hargitaidavid
 * Date: 2015.02.13.
 * Time: 7:52
 */

namespace Page;

use Behat\Mink\Exception\ElementNotFoundException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class ProfessionalProfile extends Page
{
    /**
     * @var string $path
     */
    protected $path = '/{professoinalSlug}';

    public function openTheSalon()
    {
        $salonLinkSelector = 'a.salonLink';
        $salonLink = $this->find('css', $salonLinkSelector);
        if (!$salonLink) {
            throw new ElementNotFoundException($this->getSession(), 'form', 'css', $salonLinkSelector);
        }
        $salonLink->click();
    }
}
