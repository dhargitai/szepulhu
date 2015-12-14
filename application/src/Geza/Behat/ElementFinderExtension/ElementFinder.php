<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geza\Behat\ElementFinderExtension;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

/**
 * Interface ElementFinder
 *
 * An element finder can tell if a complex element is present in the DOM.
 * It needs to a have an @see ElemetFinderBuilder to assemble the filter conditions.
 *
 * @package Geza\Behat\ElementFinderExtension
 * @author Geza Buza <bghome@gmail.com>
 */
interface ElementFinder
{
    /**
     * Constructor.
     *
     * @param ElementFinderBuilder $builder Object to build filter conditions.
     */
    public function __construct(ElementFinderBuilder $builder);

    /**
     * @param Page $page The page where to look for the element.
     * @return Element
     * @throws ElementNotFoundException
     */
    public function find(Page $page);

    /**
     * @param Page $page The page where to look for the element.
     * @return bool
     */
    public function elementExists(Page $page);
}