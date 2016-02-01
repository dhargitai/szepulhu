<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Entity\Professional\Salon;
use Application\Model\ValueObject;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class ProfessionalProfileResponse
 * @package Application\Interactor
 *
 * @property-read boolean $hasServices
 * @property-read string $firstName
 * @property-read string $lastName
 * @property-read string $profession
 * @property-read string $profilePicture
 * @property-read \Application\Entity\Professional\Salon $salon
 * @property-read string $biography
 * @property-read string $gallery
 * @property-read string $slug
 * @property-read \Application\Entity\Professional\ServiceGroup[] $serviceGroups
 * @property-read \Application\Entity\Professional\Recommendation[] $recommendations
 * @property-read string $website
 * @property-read string $blogPage
 * @property-read string $facebookPage
 * @property-read string $twitterAccount
 * @property-read \Application\Sonata\MediaBundle\Entity\Media[] $galleryImages
 */
class ProfessionalProfileResponse extends ValueObject
{
    public function __construct(
        $hasServices, $firstName, $lastName, $profession, $profilePicture, Salon $salon, $biography, $gallery, $slug,
        Collection $serviceGroups, Collection $recommendations, $website, $blogPage, $facebookPage, $twitterAccount,
        ArrayCollection $galleryImages
    ) {
        $this->value = [
            'hasServices' => $hasServices, 'firstName' => $firstName, 'lastName' => $lastName,
            'profession' => $profession, 'profilePicture' => $profilePicture, 'salon' => $salon,
            'biography' => $biography, 'gallery' => $gallery, 'slug' => $slug, 'serviceGroups' => $serviceGroups,
            'recommendations' => $recommendations, 'website' => $website, 'blogPage' => $blogPage,
            'facebookPage' => $facebookPage, 'twitterAccount' => $twitterAccount, 'galleryImages' => $galleryImages
        ];
    }
}
