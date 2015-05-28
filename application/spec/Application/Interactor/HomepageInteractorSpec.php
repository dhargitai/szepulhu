<?php

namespace spec\Application\Interactor;

use Application\Entity\ProfessionalUserRepository;
use Application\Interactor\HomepageRequest;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HomepageInteractorSpec extends ObjectBehavior
{
    public function let(ProfessionalUserRepository $professionalRepository)
    {
        $this->beConstructedWith($professionalRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\HomepageInteractor');
    }

    public function it_gathers_the_featured_professionals($professionalRepository, HomepageRequest $request)
    {
        $professionalRepository->getFeaturedProfessionals()->shouldBeCalled();
        $this->createResponse($request);
    }

    public function it_creates_homepage_response(HomepageRequest $request)
    {
        $this->createResponse($request)->shouldHaveType('Application\Interactor\HomepageResponse');
    }
}
