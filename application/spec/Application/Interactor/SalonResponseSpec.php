<?php

namespace spec\Application\Interactor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SalonResponseSpec extends ObjectBehavior
{
    private $salonData;

    public function let()
    {
        $this->salonData = array(
            'picture' => '/some/pic.jpg',
            'name' => 'XYZ Salon',
            'address' => '54. Long Street',
            'addressAdditional' => '2nd floor 5.',
            'city' => 'Neverland',
            'postCode' => '432123',
            'phone' => '765432123',
            'mapUrl' => 'http://www.map.hu',
            'map' => '/some/map/pic.jpg',
            'professionals' => array(),
        );
        $this->beConstructedWith($this->salonData);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\SalonResponse');
    }
}
