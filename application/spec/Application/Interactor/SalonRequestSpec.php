<?php

namespace spec\Application\Interactor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SalonRequestSpec extends ObjectBehavior
{
    private $requestedSlug;

    public function let()
    {
        $this->requestedSlug = 'slug';

        $this->beConstructedWith(array(
            'slug' => $this->requestedSlug,
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\SalonRequest');
    }

    public function it_holds_the_requested_slug()
    {
        $this->slug->shouldReturn($this->requestedSlug);
    }
}
