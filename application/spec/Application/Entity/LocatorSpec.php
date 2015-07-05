<?php

namespace spec\Application\Entity;

use Application\Interactor\LocationLookupResult;
use Application\Model\LocationProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

class LocatorSpec extends ObjectBehavior
{
    private $locationProvider;
    private $ip;

    public function let(LocationProvider $locationProvider, LocationLookupResult $lookupResult)
    {
        $this->ip = '8.8.8.8';
        $this->locationProvider = $locationProvider;
        $lookupResultData = [
            'ip' => $this->ip,
            'country' => 'Hungary',
            'region' => 'Csongrad',
            'city' => 'Hodmezovasarhely',
        ];
        $lookupResult->beConstructedWith($lookupResultData);
        $this->locationProvider->lookup($this->ip)->willReturn($lookupResult);
        $this->beConstructedWith($this->locationProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Entity\Locator');
    }

    public function it_looks_up_for_location(Request $request)
    {
        $request->getClientIp()->willReturn($this->ip);
        $request->getClientIp()->shouldBeCalled();
        $this->locationProvider->lookup($this->ip)->shouldBeCalled();
        $this->getLocationByRequest($request);
    }

    public function it_returns_with_location_object(Request $request)
    {
        $request->getClientIp()->willReturn($this->ip);
        $location = $this->getLocationByRequest($request);
        $location->shouldHaveType('Application\Interactor\Location');
    }
}
