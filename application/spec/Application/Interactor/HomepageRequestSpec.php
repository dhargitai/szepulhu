<?php

namespace spec\Application\Interactor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HomepageRequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\HomepageRequest');
    }
}
