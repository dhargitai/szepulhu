<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Interactor;

use Application\Entity\CityRepository;
use Application\Entity\CountyRepository;
use Application\Entity\ProfessionalUserRepository;
use Application\Form\Type\Professional\ServiceSearch;
use Symfony\Component\Form\FormFactory;

/**
 * Class HomepageInteractor
 *
 * This class represents all the actions that can be made on the homepage.
 *
 * @package Application\Interactor
 * @author Dávid Hargitai <div@diatigrah.hu>
 * @author Geza Buza <bghome@gmail.com>
 */
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
        $searchForm = $this->formFactory->create(
            new ServiceSearch(),
            $request->searchParameters,
            ['validation_groups' => ['search']]
        );
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
