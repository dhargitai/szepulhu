<?php

namespace spec\Application\Interactor;

use Application\Entity\Professional\Salon;
use Application\Entity\Professional\ServiceGroup;
use Application\Entity\ProfessionalUser;
use Application\Entity\ProfessionalUserRepository;
use Application\Interactor\ProfessionalProfileRequest;
use Application\Interactor\ProfessionalProfileResponse;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\Common\Collections\Collection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProfessionalProfileInteractorSpec extends ObjectBehavior
{
    private $request;
    private $repository;
    private $professional;
    private $serviceGroups;
    private $recommendations;

    public function let(
        ProfessionalUserRepository $repository, ProfessionalUser $professional,
        Collection $serviceGroups, Collection $recommendations
    ) {
        $this->request = new ProfessionalProfileRequest('/peldabela-szalon');
        $this->repository = $repository;
        $this->professional = $professional;
        $this->serviceGroups = $serviceGroups;
        $this->recommendations = $recommendations;

        $this->beConstructedWith($this->repository);

        $this->professional->getId()->willReturn(1);
        $this->professional->getFirstName()->willReturn('Pelda');
        $this->professional->getLastName()->willReturn('Bela');
        $this->professional->getProfession()->willReturn('Cosmetologist');
        $this->professional->getProfilePicture()->willReturn('/some/pic.jpg');
        $this->professional->getSalon()->willReturn(new Salon());
        $this->professional->getBiography()->willReturn('...');
        $this->professional->getGallery()->willReturn(new Gallery());
        $this->professional->getSlug()->willReturn('/peldabela-szalon');
        $this->professional->getServiceGroups()->willReturn($serviceGroups);
        $this->professional->getRecommendations()->willReturn($recommendations);
        $this->professional->getWebsite()->willReturn('www.peldabela.hu');
        $this->professional->getBlogPage()->willReturn('blog.peldabela.hu');
        $this->professional->getFacebookPage()->willReturn('http://facebook.com/peldabela');
        $this->professional->getTwitterAccount()->willReturn('peldabela');

        $this->repository->findOneBy(array('slug' => $this->request->slug))->willReturn($this->professional);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\ProfessionalProfileInteractor');
    }

    public function it_creates_professional_profile_response()
    {
        $this->repository->hasServices(1)->shouldBeCalled();
        $this->createProfessionalProfileResponse($this->request)->shouldHaveType(
            'Application\Interactor\ProfessionalProfileResponse'
        );
    }

    public function it_gets_the_professional_from_the_repository_by_its_slug()
    {
        $this->repository->findOneBy(array('slug' => $this->request->slug))->shouldBeCalled();
        $this->repository->hasServices(1)->shouldBeCalled();
        $this->createProfessionalProfileResponse($this->request);
    }

    public function it_gets_if_professional_has_any_services_from_the_repository()
    {
        $this->professional->getId()->shouldBeCalled();
        $this->repository->hasServices(1)->shouldBeCalled();
        $this->createProfessionalProfileResponse($this->request);
    }

    public function it_uses_the_professional_to_create_the_response()
    {
        $this->repository->hasServices(1)->shouldBeCalled();
        $response = $this->createProfessionalProfileResponse($this->request);

        $response->firstName->shouldReturn('Pelda');
        $response->lastName->shouldReturn('Bela');
        $response->profession->shouldReturn('Cosmetologist');
        $response->profilePicture->shouldReturn('/some/pic.jpg');
        $response->salon->shouldHaveType('Application\Entity\Professional\Salon');
        $response->biography->shouldReturn('...');
        $response->gallery->shouldHaveType('Application\Sonata\MediaBundle\Entity\Gallery');
        $response->slug->shouldReturn('/peldabela-szalon');
        $response->serviceGroups->shouldReturn($this->serviceGroups);
        $response->recommendations->shouldReturn($this->recommendations);
        $response->website->shouldReturn('www.peldabela.hu');
        $response->blogPage->shouldReturn('blog.peldabela.hu');
        $response->facebookPage->shouldReturn('http://facebook.com/peldabela');
        $response->twitterAccount->shouldReturn('peldabela');
    }
}
