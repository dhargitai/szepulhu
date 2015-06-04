<?php

namespace spec\Application\Interactor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FeaturedProfessionalsResponseSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(array());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\FeaturedProfessionalsResponse');
    }
}
