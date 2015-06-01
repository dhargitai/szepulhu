<?php

namespace spec\Application\Interactor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HomepageRequestSpec extends ObjectBehavior
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
        $this->shouldHaveType('Application\Interactor\HomepageRequest');
    }

    public function it_holds_the_requested_county()
    {
        $this->county->shouldReturn($this->requestedCounty);
    }
}
