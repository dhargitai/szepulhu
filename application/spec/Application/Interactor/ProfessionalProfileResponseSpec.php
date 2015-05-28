<?php

namespace spec\Application\Interactor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProfessionalProfileResponseSpec extends ObjectBehavior
{
    private $professionalData;

    public function let()
    {
        $this->professionalData = array(
            'firstName' => 'Pelda',
            'lastName' => 'Bela',
            'profession' => 'Cosmetologist',
        );
        $this->beConstructedWith($this->professionalData);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\ProfessionalProfileResponse');
    }
}
