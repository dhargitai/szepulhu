<?php
/**
 * A common, customized parent for some page object which reveals the path
 * so the linking to them can be used in feature files in a more centralized way.
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.23.
 * @package   szepulhu_functional_tests
 */

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

abstract class CustomPage extends Page
{
    /**
     * @return string
     */
    public function getUrlPath()
    {
        return $this->path;
    }

    public function waitForAjax($timeToWaitInMs = 30000)
    {
        $this->getSession()->wait($timeToWaitInMs, '(0 === jQuery.active)');
    }

    /**
     * Return a list of matching elements on the page
     *
     * @param string $name Index of the @see $this->elements configuration array.
     * @return \Behat\Mink\Element\NodeElement[]
     */
    public function getElements($name)
    {
        if (isset($this->elements[$name])) {
            $configuration = $this->elements[$name];
            if (is_array($configuration)) {
                $selector = key($configuration);
                $locator = current($configuration);
            } else {
                $selector = 'css';
                $locator = $configuration;
            }

            return $this->findAll($selector, $locator);
        }

        throw new \InvalidArgumentException(sprintf('Class %s has no element defined with "%s".', __CLASS__, $name));
    }
}
