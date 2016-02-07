<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Element\Professionals;

use Behat\Mink\Element\DocumentElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;


/**
 * Class PhotoGalleryModalWindow
 *
 * This element represents a Javascript driven modal window.
 *
 * @package Page\Element\Professionals
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class PhotoGalleryModalWindow extends Element
{
    protected $selector = '.open[data-reveal]';

    public function getLargeImageTitle()
    {
        $title = $this->callInsideIframe(
            function(DocumentElement $page) {
                $photoElement = $page->find('css', '#photoGalleryBrowser img');
                return $photoElement ? $photoElement->getAttribute('title') : '';
            }
        );

        if ($title) {
            return $title;
        }

        throw new ElementNotFoundException('Large photo cannot be found.');
    }

    public function hasPreviousButton()
    {
        return $this->callInsideIframe(
            function(DocumentElement $page) {
                return $page->hasLink('Previous');
            }
        );
    }

    public function hasNextButton()
    {
        return $this->callInsideIframe(
            function(DocumentElement $page) {
                return $page->hasLink('Next');
            }
        );
    }

    public function clickPreviousButton()
    {
        $this->callInsideIframe(
            function(DocumentElement $page) {
                $page->clickLink('Previous');
            }
        );
    }

    public function clickNextButton()
    {
        $this->callInsideIframe(
            function(DocumentElement $page) {
                $page->clickLink('Next');
            }
        );
    }

    private function callInsideIframe(callable $callback)
    {
        /** @var Element $iframeElement */
        if (($iframeElement = $this->find('css', 'iframe')) === null) {
            throw new ElementNotFoundException('Iframe element not found inside the photo modal window.');
        }
        if (!$iframeElement->hasAttribute('name')) {
            throw new \RuntimeException('Iframe element has no "name" attribute inside the photo modal window.');
        }
        $session = $this->getSession();
        $session->switchToIFrame($iframeElement->getAttribute('name'));
        $this->waitForDocumentReady();
        $result = $callback($session->getPage());
        $session->switchToIFrame(null);
        return $result;
    }

    private function waitForDocumentReady($timeToWaitInMs = 5000)
    {
        $this->getSession()->wait($timeToWaitInMs, 'typeof window.jQuery == "function"');
    }
}