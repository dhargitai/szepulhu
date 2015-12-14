<?php
/**
 *
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.23.
 * @package   szepulhu_functional_tests
 */

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;

class ProfessionalProfile extends CustomPage
{
    /**
     * @var string $path
     */
    protected $path = '/{professionalSlug}';

    public function getSlugOfTheSalon()
    {
        if (($element = $this->find('css', 'a.salonLink')) !== null) {
            return ltrim($element->getAttribute('href'), '/');
        }

        throw new ElementNotFoundException('Link to the salon page has not found.');
    }
}
