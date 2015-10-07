<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geza\Behat\ElementFinderExtension;

use Behat\Mink\Element\Element;
use Behat\Mink\Mink;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

/**
 * Class BuilderFactory
 *
 * This factory injects @see ElementFinder object into @see Element objects. To do this repalce the default factory
 * of the PageObjectExtension to this one in behat.yml configuration file.
 *
 * A PageObjectExtension is required as dependency.
 *
 * @package Geza\Behat\ElementFinderExtension
 * @author Geza Buza <bghome@gmail.com>
 */
class BuilderFactory implements Factory
{
    private $decorated;
    private $builderClass;
    private $mink;
    private $pageParameters;

    /**
     * @param Factory $decorated Another factory used to create objects.
     * @param string $builderClass Class name of an @see ElementFinderBuilder implementation.
     * @param Mink $mink
     * @param array $pageParameters
     */
    public function __construct(Factory $decorated, $builderClass, Mink $mink, array $pageParameters)
    {
        $this->decorated = $decorated;
        $this->builderClass = $builderClass;
        $this->mink = $mink;
        $this->pageParameters = $pageParameters;
    }

    /**
     * Factory method for creating element.
     *
     * It injects @see ElementFinder object to the element via setter injection. The element must implement
     * the FinderAware interface for this.
     *
     * @param string $name
     *
     * @return Element
     */
    public function createElement($name)
    {
        $element = $this->decorated->createElement($name);
        if ($element instanceof FinderAware) {
            $builder = $this->createBuilder($element);
            $finder = $this->createFinder($element, $builder);
            $element->setElementFinder($finder);
        }
        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public function createPage($name)
    {
        return $this->decorated->createPage($name);
    }

    /**
     * {@inheritdoc}
     */
    public function createInlineElement($selector)
    {
        return $this->decorated->createInlineElement($selector);
    }

    /**
     * {@inheritdoc}
     */
    public function instantiate($class)
    {
        if (is_subclass_of($class, 'SensioLabs\Behat\PageObjectExtension\PageObject\Page')) {
            return $this->instantiatePage($class);
        } elseif (is_subclass_of($class, 'SensioLabs\Behat\PageObjectExtension\PageObject\Element')) {
            return $this->instantiateElement($class);
        }

        throw new \InvalidArgumentException(sprintf('Not a page object class: %s', $class));
    }

    /**
     * @param string $pageClass
     *
     * @return Page
     */
    private function instantiatePage($pageClass)
    {
        return new $pageClass($this->mink->getSession(), $this, $this->pageParameters);
    }

    /**
     * @param string $elementClass
     *
     * @return Element
     */
    private function instantiateElement($elementClass)
    {
        return new $elementClass($this->mink->getSession(), $this);
    }

    private function generateClassName(Element $element)
    {
        $reflection = new \ReflectionClass($element);
        return sprintf('%s\ElementFinder', $reflection->getName());
    }

    /**
     * @param Element $element
     * @return ElementFinder
     */
    private function createBuilder(Element $element)
    {
        $builderClass = $this->builderClass;
        return new $builderClass($element);
    }

    /**
     * @param Element $element
     * @param ElementFinderBuilder $builder
     * @return mixed
     */
    private function createFinder(Element $element, ElementFinderBuilder $builder)
    {
        $finderClass = $this->generateClassName($element);
        $finder = new $finderClass($builder);

        return $finder;
    }
}