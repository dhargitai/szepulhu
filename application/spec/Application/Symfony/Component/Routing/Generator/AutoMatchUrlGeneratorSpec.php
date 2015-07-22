<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Application\Symfony\Component\Routing\Generator;

use Application\Symfony\Component\Routing\Generator\AutoMatchUrlGenerator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Routing\CompiledRoute;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


/**
 * Class AutoMatchUrlGeneratorSpec
 *
 * @package spec\Application\Symfony\Component\Routing\Generator
 * @author  Geza Buza <bghome@gmail.com>
 */
class AutoMatchUrlGeneratorSpec extends ObjectBehavior
{
    function let(
        UrlGenerator $decoratedGenerator, RouteCollection $routes, Route $route, CompiledRoute $compiledRoute
    ) {
        $this->initRouteCollectionDouble($routes, $route, $compiledRoute);
        $this->initGeneratorDouble($decoratedGenerator);
        $this->beConstructedWith($decoratedGenerator, $routes);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Symfony\Component\Routing\Generator\AutoMatchUrlGenerator');
    }

    function it_decorates_url_generator_object(UrlGenerator $decoratedGenerator)
    {
        $name = 'route_foo';
        $parameters = [];
        $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH;

        $decoratedGenerator->generate($name, $parameters, $referenceType)->shouldBeCalled();
        $this->generate($name, $parameters, $referenceType);

        $referenceType = AutoMatchUrlGenerator::REFERENCE_TYPE;

        $decoratedGenerator->generate($name, $parameters, $referenceType)->shouldNotBeCalled();
        $this->generate($name, $parameters, $referenceType);
    }

    function it_throws_route_not_found_exception()
    {
        $name = 'unknown_route';
        $parameters = [];
        $referenceType = AutoMatchUrlGenerator::REFERENCE_TYPE;

        $this->shouldThrow('Symfony\Component\Routing\Exception\RouteNotFoundException')
            ->duringGenerate($name, $parameters, $referenceType);
    }

    function it_should_find_route_with_matching_parameters(
        UrlGenerator $decoratedGenerator, RouteCollection $routes, Route $route1, Route $route2, Route $route3,
        CompiledRoute $compiledRoute1, CompiledRoute $compiledRoute2, CompiledRoute $compiledRoute3
    ) {
        $compiledRoute1->getVariables()->willReturn(['location']);
        $compiledRoute2->getVariables()->willReturn(['location', 'service_name']);
        $compiledRoute3->getVariables()->willReturn(['location', 'service_name', 'time']);
        $route1->compile()->willReturn($compiledRoute1);
        $route2->compile()->willReturn($compiledRoute2);
        $route3->compile()->willReturn($compiledRoute3);
        $route1->getDefault('_controller')->willReturn('test-controller-namespace:testAction');
        $route2->getDefault('_controller')->willReturn('test-controller-namespace:testAction');
        $route3->getDefault('_controller')->willReturn('test-controller-namespace:testAction');
        $routes->getIterator()->willReturn(
            new \ArrayIterator(
                [
                    'route_foo' => $route1->getWrappedObject(),
                    'route_bar' => $route2->getWrappedObject(),
                    'route_baz' => $route3->getWrappedObject(),
                ]
            )
        );

        $urlParameters = ['location' => 'Budapest', 'service_name' => 'hair cut', 'time' => null];

        $decoratedGenerator->generate('route_bar', $urlParameters, Argument::any())->shouldBeCalled();
        $this->generate('test-controller-namespace:testAction', $urlParameters, AutoMatchUrlGenerator::REFERENCE_TYPE);
    }

    private function initGeneratorDouble(UrlGenerator $decoratedGenerator)
    {
        $decoratedGenerator->generate(Argument::type('string'), Argument::cetera())
            ->willReturn('');
    }

    private function initRouteCollectionDouble(RouteCollection $routes, Route $route, CompiledRoute $compiledRoute)
    {
        $route->compile()->willReturn($compiledRoute);
        $route->getDefault('_controller')->willReturn('route_foo');
        $compiledRoute->getVariables()->willReturn([]);
        $routes->getIterator()->willReturn(new \ArrayIterator(['route_foo' => $route->getWrappedObject()]));
    }
}
