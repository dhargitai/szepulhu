<?php

namespace spec\Application\Interactor;

use Application\Entity\CityRepository;
use Application\Entity\CountyRepository;
use Application\Entity\ProfessionalUserRepository;
use Application\Interactor\FeaturedProfessionalsRequest;
use Application\Interactor\HomepageRequest;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HomepageInteractorSpec extends ObjectBehavior
{
    public function let(
        ProfessionalUserRepository $professionalRepository,
        CountyRepository $countyRepository,
        CityRepository $cityRepository
    ) {
        $this->beConstructedWith($professionalRepository, $countyRepository, $cityRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\HomepageInteractor');
    }

    public function it_gathers_the_featured_professionals_of_county(
        $professionalRepository,
        FeaturedProfessionalsRequest $request
    ) {
        $actualCounty = 'Pest';
        $numberOfFeaturedProfessionals = 6;
        $request->getCounty()->willReturn($actualCounty);
        $request->getCity()->willReturn(null);
        $request->getNumberOfFeaturedProfessionals()->willReturn($numberOfFeaturedProfessionals);
        $professionalRepository
            ->getFeaturedProfessionalsOfCounty($actualCounty, $numberOfFeaturedProfessionals)
            ->shouldBeCalled();
        $this->createFeaturedProfessionalsResponse($request);
    }

    public function it_gathers_the_featured_professionals_of_city(
        $professionalRepository,
        FeaturedProfessionalsRequest $request
    ) {
        $actualCity = 'Budapest';
        $numberOfFeaturedProfessionals = 6;
        $request->getCity()->willReturn($actualCity);
        $request->getCounty()->willReturn(null);
        $request->getNumberOfFeaturedProfessionals()->willReturn($numberOfFeaturedProfessionals);
        $professionalRepository
            ->getFeaturedProfessionalsOfCity($actualCity, $numberOfFeaturedProfessionals)
            ->shouldBeCalled();
        $this->createFeaturedProfessionalsResponse($request);
    }

    public function it_creates_homepage_response(HomepageRequest $request)
    {
        $this->createResponse($request)->shouldHaveType('Application\Interactor\HomepageResponse');
    }

    public function it_gathers_the_counties_with_featured_professionals($countyRepository, HomepageRequest $request)
    {
        $countyRepository->getCountiesWithActiveFeaturedProfessionals()->shouldBeCalled();
        $this->createResponse($request);
    }

    public function it_gathers_the_big_cities_with_featured_professionals($cityRepository, HomepageRequest $request)
    {
        $cityRepository->getCapital()->shouldBeCalled();
        $cityRepository->getBigCitiesWithActiveFeaturedProfessionals()->shouldBeCalled();
        $this->createResponse($request);
    }
}
