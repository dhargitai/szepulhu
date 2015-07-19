<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Symfony\Component\Routing\Generator;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\ConfigurableRequirementsInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;


/**
 * Class AutoMatchUrlGenerator
 *
 * This class can figure out which route to use for an action based on the given URL parameters.
 * Usage: call generateUrl($name, $parameters, $referenceType) from the controller with these values
 * - $name: it has to be the action name in the format "controller_identifier:action_name"
 * - $parameters: as usual
 * - $referenceType: pass on the value AutoMatchUrlGenerator::REFERENCE_TYPE
 *
 * @package Application\Symfony\Component\Routing\Generator
 * @author Geza Buza <bghome@gmail.com>
 */
class AutoMatchUrlGenerator implements UrlGeneratorInterface, ConfigurableRequirementsInterface
{
    const REFERENCE_TYPE = 'auto';

    private $decoratedGenerator;
    private $routes;

    public function __construct(UrlGenerator $decoratedGenerator, RouteCollection $routes)
    {
        $this->decoratedGenerator = $decoratedGenerator;
        $this->routes = $routes;
    }

    /**
     * Sets the request context.
     *
     * @param RequestContext $context The context
     *
     * @api
     */
    public function setContext(RequestContext $context)
    {
        $this->decoratedGenerator->setContext($context);
    }

    /**
     * Gets the request context.
     *
     * @return RequestContext The context
     *
     * @api
     */
    public function getContext()
    {
        return $this->decoratedGenerator->getContext();
    }

    /**
     * Generates a URL or path for a specific route based on the given parameters.
     *
     * Parameters that reference placeholders in the route pattern will substitute them in the
     * path or host. Extra params are added as query string to the URL.
     *
     * When the passed reference type cannot be generated for the route because it requires a different
     * host or scheme than the current one, the method will return a more comprehensive reference
     * that includes the required params. For example, when you call this method with $referenceType = ABSOLUTE_PATH
     * but the route requires the https scheme whereas the current scheme is http, it will instead return an
     * ABSOLUTE_URL with the https scheme and the current host. This makes sure the generated URL matches
     * the route in any case.
     *
     * If there is no route with the given name, the generator must throw the RouteNotFoundException.
     *
     * @param string $name The name of the route
     * @param mixed $parameters An array of parameters
     * @param bool|string $referenceType The type of reference to be generated (one of the constants)
     *
     * @return string The generated URL
     *
     * @throws RouteNotFoundException              If the named route doesn't exist
     * @throws MissingMandatoryParametersException When some parameters are missing that are mandatory for the route
     * @throws InvalidParameterException           When a parameter value for a placeholder is not correct because
     *                                             it does not match the requirement
     *
     * @api
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if ($referenceType === self::REFERENCE_TYPE) {

            $notNullParameters = array_filter($parameters, function($value) {return !is_null($value);});
            /** @var \Symfony\Component\Routing\Route $route */
            foreach ($this->routes as $currentName => $route) {
                if ($route->getDefault('_controller') === $name
                    && count(array_intersect($route->compile()->getVariables(), array_keys($notNullParameters))) === count($notNullParameters)
                ) {
                    return $this->decoratedGenerator->generate($currentName, $parameters, self::ABSOLUTE_PATH);
                }
            }
            throw new RouteNotFoundException(
                sprintf(
                    'Unable to generate a URL for the controller "%s" as no route with the given parameters exists.',
                    $name
                )
            );
        }

        return $this->decoratedGenerator->generate($name, $parameters, $referenceType);
    }

    /**
     * Enables or disables the exception on incorrect parameters.
     * Passing null will deactivate the requirements check completely.
     *
     * @param bool|null $enabled
     */
    public function setStrictRequirements($enabled)
    {
        $this->decoratedGenerator->setStrictRequirements($enabled);
    }

    /**
     * Returns whether to throw an exception on incorrect parameters.
     * Null means the requirements check is deactivated completely.
     *
     * @return bool|null
     */
    public function isStrictRequirements()
    {
        return $this->decoratedGenerator->isStrictRequirements();
    }
}