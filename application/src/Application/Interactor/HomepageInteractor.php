<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Entity\CityRepository;
use Application\Entity\CountyRepository;
use Application\Entity\ProfessionalUserRepository;

class HomepageInteractor
{
    private $professionalRepository;
    private $countyRepository;
    private $cityRepository;

    public function __construct(
        ProfessionalUserRepository $professionalRepository,
        CountyRepository $countyRepository,
        CityRepository $cityRepository
    ) {
        $this->professionalRepository = $professionalRepository;
        $this->countyRepository = $countyRepository;
        $this->cityRepository = $cityRepository;
    }

    public function createResponse(HomepageRequest $request)
    {
        $capitalCity = $this->cityRepository->getCapital();
        $cities = $this->cityRepository->getBigCitiesWithActiveFeaturedProfessionals();
        $counties = $this->countyRepository->getCountiesWithActiveFeaturedProfessionals();
        return new HomepageResponse(
            array(
                'capitalCity' => $capitalCity,
                'bigCitiesWithFeaturedProfessionals' => $cities,
                'countiesWithFeaturedProfessionals' => $counties,
            )
        );
    }

    public function createFeaturedProfessionalsResponse(FeaturedProfessionalsRequest $request)
    {
        $featuredProfessionals = $this->getFeaturedProfessionalsByRequest($request);
        return new FeaturedProfessionalsResponse(
            array(
                'featuredProfessionals' => $featuredProfessionals,
                'numberOfFeaturedProfessionals' => $request->getNumberOfFeaturedProfessionals(),
            )
        );
    }

    private function getFeaturedProfessionalsByRequest(FeaturedProfessionalsRequest $request)
    {
        if ($request->getCity()) {
            return $this->professionalRepository->getFeaturedProfessionalsOfCity(
                $request->getCity(),
                $request->getNumberOfFeaturedProfessionals()
            );
        }
        return $this->professionalRepository->getFeaturedProfessionalsOfCounty(
            $request->getCounty(),
            $request->getNumberOfFeaturedProfessionals()
        );
    }
}
