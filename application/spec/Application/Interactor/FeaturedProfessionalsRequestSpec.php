<?php

namespace spec\Application\Interactor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FeaturedProfessionalsRequestSpec extends ObjectBehavior
{
    private $requestedCounty;

    public function let()
    {
        $this->requestedCounty = 'Pest';

        $this->beConstructedWith(array(
            'county' => $this->requestedCounty,
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\FeaturedProfessionalsRequest');
    }

    public function it_holds_the_requested_county()
    {
        $this->getCounty()->shouldReturn($this->requestedCounty);
    }
}
