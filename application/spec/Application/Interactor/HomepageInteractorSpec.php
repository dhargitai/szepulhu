<?php

namespace spec\Application\Interactor;

use Application\Entity\CityRepository;
use Application\Entity\CountyRepository;
use Application\Entity\ProfessionalUserRepository;
use Application\Interactor\FeaturedProfessionalsRequest;
use Application\Interactor\FeaturedProfessionalsResponse;
use Application\Interactor\HomepageRequest;
use Application\Interactor\Location;
use Application\Interactor\LocationRequest;
use Application\Model\Locator;
use Application\Model\Professional\ServiceParameters;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;

class HomepageInteractorSpec extends ObjectBehavior
{
    public function let(
        ProfessionalUserRepository $professionalRepository,
        CountyRepository $countyRepository,
        CityRepository $cityRepository,
        Locator $locator,
        FormFactory $formFactory,
        Form $form
    ) {
        $this->createFormFactoryMock($formFactory, $form);
        $this->beConstructedWith($professionalRepository, $countyRepository, $cityRepository, $locator, $formFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\HomepageInteractor');
    }

    public function it_gathers_the_featured_professionals_of_location(
        ProfessionalUserRepository $professionalRepository,
        FeaturedProfessionalsRequest $featuredProfessionalsRequest,
        LocationRequest $locationRequest,
        Location $location,
        Locator $locator
    ) {
        $numberOfFeaturedProfessionals = 6;
        $featuredProfessionalsRequest->locationRequest = $locationRequest;
        $featuredProfessionalsRequest->numberOfFeaturedProfessionals = $numberOfFeaturedProfessionals;
        $featuredProfessionals = [];
        $featuredProfessionalsResponse = new FeaturedProfessionalsResponse(
            [
                'featuredProfessionals'         => $featuredProfessionals,
                'numberOfFeaturedProfessionals' => $numberOfFeaturedProfessionals,
            ]
        );

        $locator->getLocationByRequest($locationRequest)->shouldBeCalled()->willReturn($location);
        $professionalRepository->getFeaturedProfessionalsByLocation($location, $numberOfFeaturedProfessionals)
            ->shouldBeCalled()->willReturn($featuredProfessionals);


        $this->createFeaturedProfessionalsResponse($featuredProfessionalsRequest)
            ->shouldBeLike($featuredProfessionalsResponse);
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

    /**
     * @param FormFactory $formFactory
     * @param Form $form
     */
    protected function createFormFactoryMock(FormFactory $formFactory, Form $form)
    {
        $formFactory->create(Argument::cetera())->willReturn($form);
    }
}
