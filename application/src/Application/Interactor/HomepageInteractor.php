<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Entity\ProfessionalUserRepository;

class HomepageInteractor
{
    private $repository;

    public function __construct(ProfessionalUserRepository $professionalRepository)
    {
        $this->repository = $professionalRepository;
    }

    public function createResponse(HomepageRequest $request)
    {
        $featuredProfessionals = $this->repository->getFeaturedProfessionals();
        return new HomepageResponse(array(
            'featuredProfessionals' => $featuredProfessionals,
        ));
    }
}
