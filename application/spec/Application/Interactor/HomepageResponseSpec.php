<?php

namespace spec\Application\Interactor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HomepageResponseSpec extends ObjectBehavior
{
    private $initialFeaturedProfessionals;
    private $initialCounties;

    public function let()
    {
        $this->initialFeaturedProfessionals = array(
            array(
                'firstName' => 'John',
                'lastName' => 'Doe',
                'profession' => 'barber',
                'slug' => 'johnnysalon',
                'profilePicture' => '/some/path/to/pic.jpg',
            ),
            array(
                'firstName' => 'Jenny',
                'lastName' => 'Laborghini',
                'profession' => 'cosmetologist',
                'slug' => 'jennythehippi',
                'profilePicture' => '/some/path/to/anotherpic.jpg',
            )
        );

        $this->initialCounties = array('Pest', 'Csongrád');

        $this->beConstructedWith(array(
            'featuredProfessionals' => $this->initialFeaturedProfessionals,
            'countiesWithFeaturedProfessionals' => $this->initialCounties,
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Interactor\HomepageResponse');
    }

    public function it_holds_featured_professionals()
    {
        $this->featuredProfessionals->shouldReturn($this->initialFeaturedProfessionals);
    }

    public function it_holds_counties()
    {
        $this->countiesWithFeaturedProfessionals->shouldReturn($this->initialCounties);
    }
}
