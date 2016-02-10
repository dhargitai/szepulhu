<?php

/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Interactor;

/**
 * Class ProfessionalPhotoRequest
 *
 * @package Application\Interactor
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class ProfessionalPhotoRequest
{
    /** @var int */
    private $imageId;

    /** @var int $galleryId */
    private $galleryId;

    /**
     * Constructor.
     *
     * @param integer $galleryId
     * @param integer $imageId
     */
    public function __construct($galleryId, $imageId)
    {
        if (!is_numeric($galleryId)) {
            throw new \InvalidArgumentException('GalleryId argument expected to be an integer value.');
        }
        if (!is_numeric($imageId)) {
            throw new \InvalidArgumentException('ImageId argument expected to be an integer value.');
        }

        $this->imageId = $imageId;
        $this->galleryId = $galleryId;
    }

    /**
     * @return int
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * @return int
     */
    public function getGalleryId()
    {
        return $this->galleryId;
    }
}