<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Professionals;

use Page\CustomPage;
use Page\Element\Professionals\PhotoGalleryBrowser;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;


/**
 * Class PhotoGallery
 *
 * This class represents the photo gallery page of a professional user.
 *
 * @package Page\Professionals
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class PhotoGallery extends CustomPage
{
    protected $path = '/professional/profile/{slug}/photo-gallery';

    public function getLargePhotoTitle()
    {
        return $this->getGalleryBrowser()->getLargeImage()->getAttribute('title');
    }

    /**
     * @param string $direction
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function hasNavigationButton($direction)
    {
        if ($direction === 'previous') {
            return $this->getGalleryBrowser()->hasPreviousButton();
        } elseif ($direction === 'next') {
            return $this->getGalleryBrowser()->hasNextButton();
        } else {
            throw $this->createUnknownButtonException($direction);
        }
    }

    /**
     * @param string $direction
     *
     * @throws ElementNotFoundException
     */
    public function clickButton($direction)
    {
        if ($direction === 'previous') {
            $this->getGalleryBrowser()->clickPreviousButton();
        } elseif ($direction === 'next') {
            $this->getGalleryBrowser()->clickNextButton();
        } else {
            throw $this->createUnknownButtonException($direction);
        }
    }

    /**
     * @return PhotoGalleryBrowser
     */
    protected function getGalleryBrowser()
    {
        return $this->getElement('Professionals\Photo gallery browser');
    }

    /**
     * @param string $direction
     *
     * @return \InvalidArgumentException
     */
    protected function createUnknownButtonException($direction)
    {
        return new \InvalidArgumentException(sprintf('Navigation button "%s" is unknown.', $direction));
    }
}