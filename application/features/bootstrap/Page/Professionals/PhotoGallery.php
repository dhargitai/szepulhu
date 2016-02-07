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


/**
 * Class PhotoGallery
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

    public function hasPreviousButton()
    {
        return $this->getGalleryBrowser()->hasPreviousButton();
    }

    public function hasNextButton()
    {
        return $this->getGalleryBrowser()->hasNextButton();
    }

    /**
     * @return PhotoGalleryBrowser
     */
    protected function getGalleryBrowser()
    {
        return $this->getElement('Professionals\Photo gallery browser');
    }
}