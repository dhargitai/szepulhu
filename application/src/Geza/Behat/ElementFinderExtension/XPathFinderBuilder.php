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
 * Class XPathMatcher
 *
 * This implementation uses XPath expressions to implement filter conditions.
 *
 * XPath expression is like a directory path. It defines a route to visit nodes in the DOM.
 * The idea is to start the path from the element, then move to descendant node which represents the first filter
 * condition. After that go back to the original element node (as a starting point) and go downwards from there to find
 * the second node and so on.
 *
 * @package Geza\Behat\MatcherExtension
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class XPathFinderBuilder implements ElementFinderBuilder
{

    /** @var Element $element The element which properties will be matched by the finder */
    private $element;

    /** @var string $locator XPath expression to find element with matching properties */
    private $locator;

    /** @var string $pathToElement XPath expression used to go back to the element level */
    private $pathToElement;

    /**
     * Constructor.
     *
     * @param Element $element
     */
    public function __construct(Element $element)
    {
        $this->element = $element;
        $this->locator = $this->element->getXpath();
    }

    /**
     * Return a locator expression to find the complex element.
     *
     * @return string
     */
    public function getLocator()
    {
        return $this->locator;
    }

    /**
     * Return the selector type in which the locator expression is written.
     *
     * @return string
     */
    public function getSelector()
    {
        return 'xpath';
    }

    /**
     * Find a complex element which has a descendant HTML element with the given class
     * and that contains text itself or any of its descendants.
     *
     * @param string $className
     * @param string $text
     * @return ElementFinderBuilder
     */
    public function matchClassWithContent($className, $text)
    {

        $this->locator .= sprintf(
            "//*[contains(@class,'%s') and contains(descendant-or-self::text(), '%s')]%s",
            $className,
            $text,
            $this->getPathToElement()
        );

        return $this;
    }

    /**
     * Find a complex element which has a descendant HTML tag with the given attribute and attribute value.
     *
     * @param string $tagName
     * @param string $attributeName
     * @param string $value
     * @return ElementFinderBuilder
     */
    public function matchTagWithAttribute($tagName, $attributeName, $value)
    {
        $this->locator .= sprintf(
            "//%s[@%s='%s']%s", $tagName, $attributeName, $value, $this->getPathToElement()
        );

        return $this;
    }

    protected function getPathToElement()
    {
        if (is_null($this->pathToElement)) {
            $this->pathToElement = '/ancestor::' . $this->stripAxes($this->stripSelectors($this->element->getXpath()));
        }
        return $this->pathToElement;
    }

    private function stripAxes($expression)
    {
        return strpos($expression, '::') === false ? $expression : substr($expression, strpos($expression, '::') + 2);
    }

    private function stripSelectors($expression)
    {
        return ltrim($expression, '/.');
    }
}