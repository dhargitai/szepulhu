<?php

namespace Application\Model;

use Application\Entity\CityRepository;
use Application\Entity\CountyRepository;
use Application\Interactor\LocationRequest;
use Application\Interactor\Location;

class Locator
{
    /**
     * @var CityRepository
     */
    private $cityRepository;
    /**
     * @var CountyRepository
     */
    private $countyRepository;

    private $defaultLocation;

    /**
     * @param CityRepository   $cityRepository
     * @param CountyRepository $countyRepository
     */
    public function __construct(CityRepository $cityRepository, CountyRepository $countyRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->countyRepository = $countyRepository;
    }

    /**
     * @param LocationRequest $request
     *
     * @return Location
     */
    public function findClosestFeaturedProfessionals(LocationRequest $request)
    {
        try {
            $closestCity = $this->cityRepository->getClosestBigCityWithActiveFeaturedProfessionals($request);
            return new Location([
                'name' => $closestCity['name'],
                'type' => Location::TYPE_CITY,
            ]);
        } catch (\DomainException $e) {
            return $this->getDefaultLocation();
        }
    }

    /**
     * @param LocationRequest $request
     *
     * @return Location
     */
    public function getLocationByRequest(LocationRequest $request)
    {
        try {
            return new Location([
                'name' => $request->name,
                'type' => $request->type,
            ]);
        } catch (\Exception $e) {
            return $this->getDefaultLocation();
        }
    }

    /**
     * @return Location
     */
    public function getDefaultLocation()
    {
        if (!$this->defaultLocation) {
            $capital = $this->cityRepository->getCapital();
            $this->defaultLocation = new Location(
                [
                    'type' => Location::TYPE_CITY,
                    'name' => $capital->getName(),
                ]
            );
        }
        return $this->defaultLocation;
    }
}
