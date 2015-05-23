<?php
/**
 *
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.23.
 * @package   szepulhu_functional_tests
 */

namespace Page;

use Behat\Mink\Exception\ElementNotFoundException;

class ProfessionalProfile extends CustomPage
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
