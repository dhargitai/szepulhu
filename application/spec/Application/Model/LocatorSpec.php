<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Application\Model;

use Application\Entity\City;
use Application\Entity\CityRepository;
use Application\Entity\CountyRepository;
use Application\Interactor\Location;
use Application\Interactor\LocationRequest;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class LocatorSpec
 *
 * @package spec\Application\Model
 * @author Hargitai Dávid <div@diatigrah.hu>
 */
class LocatorSpec extends ObjectBehavior
{
    private $location;
    private $locationName = 'Kukutyin';

    public function let(CityRepository $cityRepository, CountyRepository $countyRepository)
    {
        $this->location = new Location(
            Location::TYPE_CITY,
            $this->locationName
        );

        $this->beConstructedWith($cityRepository, $countyRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Model\Locator');
    }

    public function it_returns_the_default_location_to_an_empty_location_request(
        CityRepository $cityRepository,
        City $capital
    ) {
        $latitude = $longitude = $ip = '';
        $request = new LocationRequest('', '', $latitude, $longitude, $ip);

        $capital->getName()->shouldBeCalled()->willReturn($this->locationName);
        $cityRepository->getCapital()->shouldBeCalled()->willReturn($capital);

        $this->getLocationByRequest($request)->shouldBeLike($this->location);
    }

    public function it_returns_the_location_object_if_the_correct_request_data_is_available()
    {
        $latitude = $longitude = $ip = '';
        $request = new LocationRequest($this->locationName, Location::TYPE_CITY, $latitude, $longitude, $ip);

        $this->getLocationByRequest($request)->shouldBeLike($this->location);
    }

    public function it_returns_the_capital_for_default_location(CityRepository $cityRepository, City $capital)
    {
        $capital->getName()->willReturn($this->locationName);
        $cityRepository->getCapital()->willReturn($capital);

        $this->getDefaultLocation()->shouldBeLike($this->location);
    }

    public function it_returns_the_default_location_as_closest_location_to_an_empty_location_request(
        LocationRequest $request,
        CityRepository $cityRepository,
        City $capital
    ) {
        $capital->getName()->shouldBeCalled()->willReturn($this->locationName);
        $cityRepository->getClosestBigCityWithActiveFeaturedProfessionals($request)
            ->shouldBeCalled()
            ->willThrow('\DomainException');
        $cityRepository->getCapital()->shouldBeCalled()->willReturn($capital);

        $this->findClosestFeaturedProfessionals($request)->shouldBeLike($this->location);
    }

    public function it_returns_the_closest_city_location_object(
        LocationRequest $request,
        CityRepository $cityRepository,
        City $city
    ) {
        $city->getName()->willReturn($this->locationName);
        $cityRepository->getClosestBigCityWithActiveFeaturedProfessionals($request)
            ->shouldBeCalled()
            ->willReturn($city);

        $this->findClosestFeaturedProfessionals($request)->shouldBeLike($this->location);
    }
}
