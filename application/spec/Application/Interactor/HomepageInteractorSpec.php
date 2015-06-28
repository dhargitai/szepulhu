<?php

namespace spec\Application\Interactor;

use Application\Entity\CityRepository;
use Application\Entity\CountyRepository;
use Application\Entity\ProfessionalUserRepository;
use Application\Interactor\FeaturedProfessionalsRequest;
use Application\Interactor\HomepageRequest;
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
        FormFactory $formFactory,
        Form $form
    ) {
        $this->createFormFactoryMock($formFactory, $form);
        $this->beConstructedWith($professionalRepository, $countyRepository, $cityRepository, $formFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\HomepageInteractor');
    }

    public function it_gathers_the_featured_professionals_of_county(
        $professionalRepository
    ) {
        $actualCounty = 'Pest';
        $numberOfFeaturedProfessionals = 6;
        $request = new FeaturedProfessionalsRequest(
            [
                'city' => '',
                'county' => $actualCounty,
                'numberOfFeaturedProfessionals' => $numberOfFeaturedProfessionals,
            ]
        );

        $professionalRepository
            ->getFeaturedProfessionalsOfCounty($actualCounty, $numberOfFeaturedProfessionals)
            ->shouldBeCalled();
        $this->createFeaturedProfessionalsResponse($request);
    }

    public function it_gathers_the_featured_professionals_of_city(
        $professionalRepository
    ) {
        $actualCity = 'Budapest';
        $numberOfFeaturedProfessionals = 6;
        $request = new FeaturedProfessionalsRequest(
            [
                'city' => $actualCity,
                'county' => '',
                'numberOfFeaturedProfessionals' => $numberOfFeaturedProfessionals,
            ]
        );
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

    /**
     * @param FormFactory $formFactory
     * @param Form $form
     */
    protected function createFormFactoryMock(FormFactory $formFactory, Form $form)
    {
        $formFactory->create(Argument::cetera())->willReturn($form);
    }
}
