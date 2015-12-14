<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geza\Behat\ElementFinderExtension;

/**
 * Interface FinderAware
 *
 * This represents a setter injection pattern.
 * Classes which need to have an @see ElementFinder have to implement this interface.
 *
 * @package Geza\Behat\ElementFinderExtension
 * @author Geza Buza <bghome@gmail.com>
 */
interface FinderAware
{
    /**
     * @param ElementFinder $finder
     * @return void
     */
    public function setElementFinder(ElementFinder $finder);

    /**
     * @return ElementFinder
     */
    public function getElementFinder();
}