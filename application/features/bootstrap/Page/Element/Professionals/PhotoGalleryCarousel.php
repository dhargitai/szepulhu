<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Element\Professionals;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;


/**
 * Class PhotoGalleryCarousel
 * @package Page\Element\Professionals
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class PhotoGalleryCarousel extends Element
{
    protected $selector = '#professionalGallery';

    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function clickPreviousButton()
    {
        $this->pressButton('Previous');
    }

    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function clickNextButton()
    {
        $this->pressButton('Next');
    }

    /**
     * @param int $position
     */
    public function clickPhoto($position)
    {
         $this->findNthPhoto($position)->click();
    }

    /**
     * @param int $position
     * @return Element
     */
    protected function findNthPhoto($position)
    {
        $currentPosition = 1;

        /** @var Element $photoLink */
        foreach ($this->findAll('css', 'div.columns a') as $photoLink) {
            if ($photoLink->isVisible() && $currentPosition++ === $position) {
                return $photoLink;
            }
        }

        throw new ElementNotFoundException(sprintf('Photo gallery has no visible image at position %d.', $position));
    }
}