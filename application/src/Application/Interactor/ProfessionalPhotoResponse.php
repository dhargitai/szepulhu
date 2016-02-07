<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Interactor;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\Collection;


/**
 * Class ProfessionalPhotoResponse
 * @package Application\Interactor
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class ProfessionalPhotoResponse
{
    /**
     * @var Media
     */
    private $currentImage;
    /**
     * @var Media
     */
    private $nextImage;
    /**
     * @var Media
     */
    private $previousImage;

    /** @var int $galleryId */
    private $galleryId;

    public function __construct($galleryId, Media $current, Media $next = null, Media $previous = null)
    {
        $this->galleryId = $galleryId;
        $this->currentImage = $current;
        $this->nextImage = $next;
        $this->previousImage = $previous;
    }

    /**
     * @return Media
     */
    public function getCurrentImage()
    {
        return $this->currentImage;
    }

    /**
     * @return Media|null
     */
    public function getNextImage()
    {
        return $this->nextImage;
    }

    /**
     * @return Media|null
     */
    public function getPreviousImage()
    {
        return $this->previousImage;
    }

    /**
     * @return int
     */
    public function getGalleryId()
    {
        return $this->galleryId;
    }
}