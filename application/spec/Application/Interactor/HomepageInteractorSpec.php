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
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormView;

class HomepageInteractorSpec extends ObjectBehavior
{
    public function let(
        ProfessionalUserRepository $professionalRepository,
        CountyRepository $countyRepository,
        CityRepository $cityRepository,
        Locator $locator,
        FormFactory $formFactory,
        Form $form,
        FormView $formView
    ) {
        $this->createFormFactoryMock($formFactory, $form);
        $this->beConstructedWith($professionalRepository, $countyRepository, $cityRepository, $locator, $formFactory);
        $this->initCityRepositoryDouble($cityRepository);
        $this->initCountyRepositoryDouble($countyRepository);
        $this->initFormFactoryDouble($formFactory, $form);
        $this->initFormDouble($form, $formView);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\HomepageInteractor');
    }

    public function it_gathers_the_featured_professionals_of_location(
        ProfessionalUserRepository $professionalRepository,
        Locator $locator
    ) {
        $locationRequest = new LocationRequest('Pecs', Location::TYPE_CITY, 0, 0, '127.0.0.1');
        $location = new Location(Location::TYPE_CITY, 'Pecs');
        $numberOfFeaturedProfessionals = 6;
        $featuredProfessionalsRequest = new FeaturedProfessionalsRequest(
            $locationRequest, $numberOfFeaturedProfessionals
        );
        $featuredProfessionals = [];
        $featuredProfessionalsResponse = new FeaturedProfessionalsResponse(
            $featuredProfessionals,
            $numberOfFeaturedProfessionals,
            $location
        );

        $locator->getLocationByRequest($locationRequest)->shouldBeCalled()->willReturn($location);
        $professionalRepository->getFeaturedProfessionalsByLocation($location, $numberOfFeaturedProfessionals)
            ->shouldBeCalled()->willReturn($featuredProfessionals);


        $this->createFeaturedProfessionalsResponse($featuredProfessionalsRequest)
            ->shouldBeLike($featuredProfessionalsResponse);
    }

    public function it_creates_homepage_response()
    {
        $request = new HomepageRequest();
        $this->createResponse($request)->shouldHaveType('Application\Interactor\HomepageResponse');
    }

    public function it_gathers_the_counties_with_featured_professionals($countyRepository)
    {
        $request = new HomepageRequest();
        $countyRepository->getCountiesWithActiveFeaturedProfessionals()->shouldBeCalled();
        $this->createResponse($request);
    }

    public function it_gathers_the_big_cities_with_featured_professionals($cityRepository)
    {
        $request = new HomepageRequest();
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

    private function initCityRepositoryDouble(CityRepository $cityRepository)
    {
        $cityRepository->getBigCitiesWithActiveFeaturedProfessionals()->willReturn([]);
        $cityRepository->getClosestBigCityWithActiveFeaturedProfessionals()->willReturn([]);
        $cityRepository->getCapital()->willReturn('');
    }

    private function initCountyRepositoryDouble(CountyRepository $countyRepository)
    {
        $countyRepository->getCountiesWithActiveFeaturedProfessionals()->willReturn([]);
    }

    private function initFormFactoryDouble(FormFactory $formFactory, Form $form)
    {
        $formFactory->create(Argument::cetera())->willReturn($form);
    }

    private function initFormDouble(Form $form, FormView $formView)
    {
        $form->createView()->willReturn($formView);
    }
}
