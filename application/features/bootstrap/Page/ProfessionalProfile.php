<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page;

use Page\Element\Professionals\PhotoGalleryModalWindow;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;
use Page\Element\Professionals\PhotoGalleryCarousel;

/**
 * Class ProfessionalProfile
 *
 * This page represents the public profile of a professional user.
 *
 * @package Page
 * @author Dávid Hargitai <div@diatigrah.hu>
 * @author Geza Buza <bghome@gmail.com>
 */
class ProfessionalProfile extends CustomPage
{
    /**
     * @var string $path
     */
    protected $path = '/{slug}';

    public function getSlugOfTheSalon()
    {
        if (($element = $this->find('css', 'a.salonLink')) !== null) {
            return ltrim($element->getAttribute('href'), '/');
        }

        throw new ElementNotFoundException('Link to the salon page has not found.');
    }

    public function clickNavigationButton($currentNavigationButton)
    {
        if ($currentNavigationButton === 'previous') {
            $this->getPhotoGallery()->clickPreviousButton();
        } elseif ($currentNavigationButton === 'next') {
            $this->getPhotoGallery()->clickNextButton();
        } else {
            throw new \DomainException(sprintf('Navigation button "%s" is unknown.', $currentNavigationButton));
        }
    }

    /**
     * Return a string which represents the DOM elements state withing the photo gallery
     *
     * When the photo carousel is rotated, this method will return a different value.
     *
     * @return string MD5 hash of the photo gallery element
     */
    public function getPhotoGalleryState()
    {
        return md5($this->getPhotoGallery()->getHtml());
    }

    /**
     * @param int $n
     */
    public function clickOnTheNthPhoto($n)
    {
        $this->getPhotoGallery()->clickPhoto($n);
    }

    /**
     * @param int $n
     *
     * @return null|string
     */
    public function getTitleOfNthPhoto($n)
    {
        return $this->getPhotoGallery()->getPhotoTitle($n);
    }

    /**
     * @return PhotoGalleryCarousel
     */
    protected function getPhotoGallery()
    {
        return $this->getElement('Professionals\Photo gallery carousel');
    }

    public function isPhotoModalWindowOpen()
    {
        return $this->waitFor(
            3,
            function(self $profile) {
                return $profile->hasElement('Professionals\PhotoGalleryModalWindow');
            }
        );
    }

    public function getPhotoTitleInModalWindow()
    {
        return $this->getModalWindow()->getLargeImageTitle();
    }

    public function hasNavigationButton($direction)
    {
        if ($direction === 'next') {
            return $this->getModalWindow()->hasNextButton();
        } elseif ($direction === 'previous') {
            return $this->getModalWindow()->hasPreviousButton();
        }
    }

    /**
     * @return PhotoGalleryModalWindow
     */
    private function getModalWindow()
    {
        return $this->getElement('Professionals\PhotoGalleryModalWindow');
    }
}
