<?php

namespace spec\Application\Interactor;

use Application\Entity\Professional\Salon;
use Application\Entity\Professional\SalonRepository;
use Application\Interactor\SalonRequest;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SalonInteractorSpec extends ObjectBehavior
{
    private $request;
    private $repository;
    private $salon;

    public function let(SalonRepository $repository, Salon $salon)
    {
        $this->request = new SalonRequest(['slug' => '/peldabela-szalon']);
        $this->repository = $repository;
        $this->salon = $salon;

        $this->beConstructedWith($repository);

        $this->salon->getPicture()->willReturn('/some/pic.jp');
        $this->salon->getName()->willReturn('XYZ Salo');
        $this->salon->getAddress()->willReturn('54. Long Stree');
        $this->salon->getAddressAdditional()->willReturn('2nd floor 5.');
        $this->salon->getCity()->willReturn('Neverlan');
        $this->salon->getPostCode()->willReturn('43212');
        $this->salon->getPhone()->willReturn('76543212');
        $this->salon->getMapUrl()->willReturn('http://www.map.h');
        $this->salon->getMap()->willReturn('/some/map/pic.jp');
        $this->salon->getProfessionals()->willReturn(array());

        $this->repository->findOneBy(array('slug' => $this->request->slug))->willReturn($this->salon);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\SalonInteractor');
    }

    public function it_creates_salon_response()
    {
        $this->createSalonResponse($this->request)->shouldHaveType('Application\Interactor\SalonResponse');
    }

    public function it_gets_the_salon_from_the_repository_by_its_slug()
    {
        $this->repository->findOneBy(array('slug' => $this->request->slug))->shouldBeCalled();
        $this->createSalonResponse($this->request);
    }

    public function it_uses_the_salon_to_create_the_response()
    {
        $response = $this->createSalonResponse($this->request);

        $response->picture->shouldReturn('/some/pic.jp');
        $response->name->shouldReturn('XYZ Salo');
        $response->address->shouldReturn('54. Long Stree');
        $response->addressAdditional->shouldReturn('2nd floor 5.');
        $response->city->shouldReturn('Neverlan');
        $response->postCode->shouldReturn('43212');
        $response->phone->shouldReturn('76543212');
        $response->mapUrl->shouldReturn('http://www.map.h');
        $response->map->shouldReturn('/some/map/pic.jp');
        $response->professionals->shouldReturn(array());
    }
}
