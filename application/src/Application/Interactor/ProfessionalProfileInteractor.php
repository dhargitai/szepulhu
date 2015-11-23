<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Entity\Professional\ServiceGroup;
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
        return new ProfessionalProfileResponse(
            $this->repository->hasServices($professional->getId()),
            $professional->getFirstName(),
            $professional->getLastName(),
            $professional->getProfession(),
            $professional->getProfilePicture(),
            $professional->getSalon(),
            $professional->getBiography(),
            $professional->getGallery(),
            $professional->getSlug(),
            $professional->getServiceGroups(),
            $professional->getRecommendations(),
            $professional->getWebsite(),
            $professional->getBlogPage(),
            $professional->getFacebookPage(),
            $professional->getTwitterAccount()
        );
    }
}
