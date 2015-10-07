<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Element\Professionals;

use Geza\Behat\ElementFinderExtension\FinderAware;
use Geza\Behat\ElementFinderExtension\ElementFinder;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

/**
 * Class ElementFinder
 *
 * This class represents a featured professional element.
 *
 * @package Page\Element\Professionals
 * @author Geza Buza <bghome@gmail.com>
 */
class FeaturedProfessional extends Element implements FinderAware
{
    protected $selector = '.featuredProfessional';

    private $finder;

    public function setElementFinder(ElementFinder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @return ElementFinder
     */
    public function getElementFinder()
    {
        return $this->finder;
    }
}