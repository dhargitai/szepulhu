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
use Application\Model\Locator;
use Application\Form\Type\Professional\ServiceSearch;
use Symfony\Component\Form\FormFactory;

/**
 * Class HomepageInteractor
 *
 * This class represents all the actions that can be made on the homepage.
 *
 * @package Application\Interactor
 * @author  Dávid Hargitai <div@diatigrah.hu>
 * @author  Geza Buza <bghome@gmail.com>
 */
class HomepageInteractor
{
    private $professionalRepository;
    private $countyRepository;
    private $cityRepository;
    private $locator;
    private $formFactory;

    /**
     * @param ProfessionalUserRepository $professionalRepository
     * @param CountyRepository           $countyRepository
     * @param CityRepository             $cityRepository
     * @param Locator                    $locator
     * @param FormFactory                $formFactory
     */
    public function __construct(
        ProfessionalUserRepository $professionalRepository,
        CountyRepository $countyRepository,
        CityRepository $cityRepository,
        Locator $locator,
        FormFactory $formFactory
    ) {
        $this->professionalRepository = $professionalRepository;
        $this->countyRepository = $countyRepository;
        $this->cityRepository = $cityRepository;
        $this->locator = $locator;
        $this->formFactory = $formFactory;
    }

    /**
     * @param HomepageRequest $request
     *
     * @return HomepageResponse
     */
    public function createResponse(HomepageRequest $request)
    {
        $searchForm = $this->formFactory->create(
            new ServiceSearch(),
            $request->searchParameters,
            ['validation_groups' => ['search']]
        );
        return new HomepageResponse($searchForm->createView());
    }

    public function createFeaturedProfessionalsRequestFromLocation(Location $location, $maxItems)
    {
        return new FeaturedProfessionalsRequest(
            $location,
            $maxItems
        );
    }

    public function createFeaturedProfessionalsRequestFromLocationRequest(LocationRequest $request, $maxItems)
    {
        return new FeaturedProfessionalsRequest(
            $this->locator->findClosestFeaturedProfessionals($request),
            $maxItems
        );
    }

    /**
     * @param FeaturedProfessionalsRequest $request
     *
     * @return FeaturedProfessionalsResponse
     */
    public function createFeaturedProfessionalsResponse(FeaturedProfessionalsRequest $request)
    {
        $locationFound = $request->location;
        $featuredProfessionals = $this->professionalRepository->getFeaturedProfessionalsByLocation(
            $locationFound,
            $request->numberOfFeaturedProfessionals
        );
        $cities = $this->cityRepository->getBigCitiesWithActiveFeaturedProfessionals();
        $counties = $this->countyRepository->getCountiesWithActiveFeaturedProfessionals();
        return new FeaturedProfessionalsResponse(
            $featuredProfessionals,
            $request->numberOfFeaturedProfessionals,
            $locationFound,
            $cities,
            $counties
        );
    }

    /**
     * @param LocationRequest $request
     *
     * @return Location
     */
    public function createClosestFeaturedProfessionalsLocationResponse(LocationRequest $request)
    {
        return $this->locator->findClosestFeaturedProfessionals($request);
    }
}
