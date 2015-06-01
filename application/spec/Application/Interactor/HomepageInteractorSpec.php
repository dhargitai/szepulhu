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
        $request->getCounty()->willReturn('Pest');
        $request->getCity()->willReturn(null);
        $professionalRepository->getFeaturedProfessionalsOfCounty($request->county)->shouldBeCalled();
        $this->createFeaturedProfessionalsResponse($request);
    }

    public function it_gathers_the_featured_professionals_of_city(
        $professionalRepository,
        FeaturedProfessionalsRequest $request
    ) {
        $request->getCity()->willReturn('Budapest');
        $request->getCounty()->willReturn(null);
        $professionalRepository->getFeaturedProfessionalsOfCity($request->city)->shouldBeCalled();
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
}
