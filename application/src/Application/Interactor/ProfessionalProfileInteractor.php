<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Entity\ProfessionalUserRepository;

class ProfessionalProfileInteractor
{
    private $repository;

    public function __construct(ProfessionalUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createProfessionalProfileResponse(ProfessionalProfileRequest $request)
    {
        $professional = $this->repository->findOneBy(array('slug' => $request->slug));
        return new ProfessionalProfileResponse(array(
            'hasServices' => $this->repository->hasServices($professional->getId()),
            'firstName' => $professional->getFirstName(),
            'lastName' => $professional->getLastName(),
            'profession' => $professional->getProfession(),
            'profilePicture' => $professional->getProfilePicture(),
            'salon' => $professional->getSalon(),
            'biography' => $professional->getBiography(),
            'gallery' => $professional->getGallery(),
            'slug' => $professional->getSlug(),
            'serviceGroups' => $professional->getServiceGroups(),
            'recommendations' => $professional->getRecommendations(),
            'website' => $professional->getWebsite(),
            'blogPage' => $professional->getBlogPage(),
            'facebookPage' => $professional->getFacebookPage(),
            'twitterAccount' => $professional->getTwitterAccount(),
        ));
    }
}
