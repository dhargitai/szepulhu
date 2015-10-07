<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geza\Behat\ElementFinderExtension;

use Behat\Mink\Element\Element;

/**
 * Interface ElementFinderBuilder
 *
 * This provides an SQL-like builder interface to find a matching complex element in the DOM.
 *
 * Lets suppose we have a list of featured items on a HTML page. This is not a single HTML tag, but a complex construct
 * of DIV, SPAN, P, A tags, something like this:
 * ~~~
 * <div class="featured-item">
 *      <span class="name">Don Pedro</span>
 *      <img title="Baking a pizza" src="foo/bar/pizza-thumbnail-medium.png" />
 * </div>
 * ~~~
 *
 * When you want to find a featured item from Don Pedro's pizza, it's not enough to write a CSS selector for finding
 * the person's name and another one for finding the photo, because the first could match an item where Don Pedro is
 * preparing salami, and the second could match an item where Don Pepe is baking a pizza. So both filter conditions
 * must met for the same featured item element.
 * This can be achieved by this builder like below:
 * ~~~
 * $element = new Element('.featured-item');
 * $builder = new ElementFinderBuilder($element);
 * $builder->matchClassWithContent('name', 'Don Pedro');
 * $builder->matchTagWithAttribute('img', 'title', 'Baking a pizza');
 * echo 'Featured item ' . $element->find($builder->getSelector(), $builder->getLocator()) ? 'found' : 'not found';
 * ~~~
 *
 * The selector is usually "css" or "xpath". The locator is similar to a compiled SQL string, but it contains
 * the expression to find the complex element with the given constraints.
 *
 * @package Geza\Behat\ElementFinderExtension
 * @author Geza Buza <bghome@gmail.com>
 */
interface ElementFinderBuilder
{
    /**
     * Constructor.
     *
     * @param Element $element
     */
    public function __construct(Element $element);

    /**
     * Find a complex element which has a descendant HTML element with the given class
     * and that contains text itself or any of its descendants.
     *
     * @param string $className
     * @param string $text
     * @return ElementFinderBuilder
     */
    public function matchClassWithContent($className, $text);

    /**
     * Find a complex element which has a descendant HTML tag with the given attribute and attribute value.
     *
     * @param string $tagName
     * @param string $attributeName
     * @param string $value
     * @return ElementFinderBuilder
     */
    public function matchTagWithAttribute($tagName, $attributeName, $value);

    /**
     * Return a locator expression to find the complex element.
     *
     * @return string
     */
    public function getLocator();

    /**
     * Return the selector type in which the locator expression is written.
     *
     * @return string
     */
    public function getSelector();
}