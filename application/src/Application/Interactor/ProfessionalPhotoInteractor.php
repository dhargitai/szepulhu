<?php

/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Interactor;

use Application\Sonata\MediaBundle\Entity\Gallery;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;
use Application\Sonata\MediaBundle\Entity\GalleryRepository;
use Application\Sonata\MediaBundle\Entity\Media;
use Application\Sonata\MediaBundle\Entity\MediaRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Class ProfessionalPhotoInteractor
 *
 * @package Application\Interactor
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class ProfessionalPhotoInteractor
{
    /**
     * @var GalleryRepository
     */
    private $galleryRepository;

    /**
     * @var MediaRepository
     */
    private $mediaRepository;

    /**
     * ProfessionalPhotoInteractor constructor.
     *
     * @param GalleryRepository $galleryRepository
     * @param MediaRepository $mediaRepository
     */
    public function __construct(GalleryRepository $galleryRepository, MediaRepository $mediaRepository)
    {
        $this->galleryRepository = $galleryRepository;
        $this->mediaRepository = $mediaRepository;
    }

    public function createResponse(ProfessionalPhotoRequest $photoRequest)
    {
        /** @var Gallery $gallery */
        if (!($gallery = $this->galleryRepository->find($photoRequest->getGalleryId()))) {
            throw new \RuntimeException(
                sprintf('Photo gallery with ID "%d" does not exist.', $photoRequest->getGalleryId())
            );
        }

        $current = $this->loadImageById($gallery, $photoRequest->getImageId());

        if (!$current instanceof Media) {
            throw new \RuntimeException(
                sprintf('Photo gallery has no image associated with ID "%d".', $photoRequest->getImageId())
            );
        }

        $position = $current->getGalleryHasMedias()->get(0)->getPosition();
        $next = $this->loadImageByPosition($gallery, $position + 1);
        $previous = $this->loadImageByPosition($gallery, $position - 1);

        return new ProfessionalPhotoResponse($gallery->getId(), $current, $next, $previous);
    }

    /**
     * @param Gallery $gallery
     * @param int $imageId
     * @return null|\Sonata\MediaBundle\Model\MediaInterface
     */
    private function loadImageById(Gallery $gallery, $imageId)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('media_id', $imageId))
            ->setMaxResults(1);

        return $this->loadImageByCriteria($gallery, $criteria);
    }

    /**
     * @param Gallery $gallery
     * @param $position
     * @return null|\Sonata\MediaBundle\Model\MediaInterface
     */
    private function loadImageByPosition(Gallery $gallery, $position)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('position', $position))
            ->setMaxResults(1);

        return $this->loadImageByCriteria($gallery, $criteria);
    }

    /**
     * @param Gallery $gallery
     * @param $criteria
     * @return null|\Sonata\MediaBundle\Model\MediaInterface
     */
    private function loadImageByCriteria(Gallery $gallery, $criteria)
    {
        $associations = $gallery->getGalleryHasMedias()->matching($criteria);

        /** @var GalleryHasMedia $galleryHasMediaEntity */
        $galleryHasMediaEntity = $associations->first();

        return $galleryHasMediaEntity ? $galleryHasMediaEntity->getMedia() : null;
    }
}