<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page;

use Exception\UnexpectedPageTitleException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

/**
 * Class CustomPage
 *
 * Extend capabilities of the PageObject extension.
 *
 * @package Page
 * @author Dávid Hargitai <div@diatigrah.hu>
 * @author Geza Buza <bghome@gmail.com>
 */
abstract class CustomPage extends Page
{
    /** @var string $title Define page title text. It can be a PCRE. */
    protected $title;

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
     * @param string $name Both inline or custom elements can be given. Same as @see Page::getElement() expects.
     * @return \Behat\Mink\Element\NodeElement[]
     */
    public function getElements($name)
    {
        $element = $this->createElement($name);

        if (($elements = $this->findAll('xpath', $element->getXpath())) && count($elements) == 0) {
            throw new ElementNotFoundException(sprintf('"%s" element is not present on the page', $name));
        }

        return $elements;
    }

    /**
     * Overload to verify if the current url matches the expected one. Throw an exception otherwise.
     *
     * Use non set parameters in the URL path as wildcards.
     *
     * @param array $urlParameters
     * @throws UnexpectedPageException
     */
    protected function verifyUrl(array $urlParameters = array())
    {
        $urlPattern = sprintf('#%s#U', preg_replace('#\\\{[^{}]+\\\}#', '.*', preg_quote($this->getUrl($urlParameters))));
        if (!preg_match($urlPattern, $this->getSession()->getCurrentUrl())) {
            throw new UnexpectedPageException(
                sprintf(
                    'Expected to be on "%s" but found "%s" instead',
                    $this->getUrl($urlParameters),
                    $this->getSession()->getCurrentUrl()
                )
            );
        }
    }

    /**
     * Check whether the title of the current page matches
     *
     * If the title variable is null, the verification is skipped.
     *
     * @throws UnexpectedPageTitleException
     */
    public function verifyTitle()
    {
        $titleElement = $this->getSession()->getPage()->find('css', 'head > title');
        $currentTitle = is_null($titleElement) ? '' : $titleElement->getHtml();
        if (isset($this->title) && !preg_match(sprintf('#%s#', str_replace('#', '\#', $this->title)), $currentTitle)) {
            throw new UnexpectedPageTitleException(
                sprintf(
                    'Expected to see page title "%s", but got "%s".',
                    $this->title,
                    $currentTitle
                )
            );
        }
    }
}
