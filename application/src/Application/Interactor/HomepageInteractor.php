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
use Application\Form\Type\Professional\ServiceSearch;
use Symfony\Component\Form\FormFactory;

class HomepageInteractor
{
    private $professionalRepository;
    private $countyRepository;
    private $cityRepository;

    public function __construct(
        ProfessionalUserRepository $professionalRepository,
        CountyRepository $countyRepository,
        CityRepository $cityRepository,
        FormFactory $formFactory
    ) {
        $this->professionalRepository = $professionalRepository;
        $this->countyRepository = $countyRepository;
        $this->cityRepository = $cityRepository;
        $this->formFactory = $formFactory;
    }

    public function createResponse(HomepageRequest $request)
    {
        $capitalCity = $this->cityRepository->getCapital();
        $cities = $this->cityRepository->getBigCitiesWithActiveFeaturedProfessionals();
        $counties = $this->countyRepository->getCountiesWithActiveFeaturedProfessionals();
        $searchForm = $this->formFactory->create(new ServiceSearch(), $request->searchParameters);
        return new HomepageResponse(
            array(
                'capitalCity' => $capitalCity,
                'bigCitiesWithFeaturedProfessionals' => $cities,
                'countiesWithFeaturedProfessionals' => $counties,
                'searchForm' => $searchForm->createView()
            )
        );
    }

    public function createFeaturedProfessionalsResponse(FeaturedProfessionalsRequest $request)
    {
        $featuredProfessionals = $this->getFeaturedProfessionalsByRequest($request);
        return new FeaturedProfessionalsResponse(
            array(
                'featuredProfessionals' => $featuredProfessionals,
                'numberOfFeaturedProfessionals' => $request->numberOfFeaturedProfessionals,
            )
        );
    }

    private function getFeaturedProfessionalsByRequest(FeaturedProfessionalsRequest $request)
    {
        if ($request->city) {
            return $this->professionalRepository->getFeaturedProfessionalsOfCity(
                $request->city,
                $request->numberOfFeaturedProfessionals
            );
        }
        return $this->professionalRepository->getFeaturedProfessionalsOfCounty(
            $request->county,
            $request->numberOfFeaturedProfessionals
        );
    }
}
