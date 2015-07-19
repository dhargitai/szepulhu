<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\NativeRequestHandler;
use Symfony\Component\Form\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SeoRequestHandler
 *
 * This class extracts the form data from HTTP GET request, where the URL path is in the following SEO friendly format:
 * /some/optional/prefix/param1/value1/param2/value2?optional_query_string
 *
 * @package Application\Form
 */
class SeoRequestHandler implements RequestHandlerInterface
{
    private $decoratedHandler;

    /**
     * Constructor
     *
     * @param NativeRequestHandler $decoratedHandler
     */
    public function __construct(NativeRequestHandler $decoratedHandler)
    {
        $this->decoratedHandler = $decoratedHandler;
    }

    /**
     * Submits a form if it was submitted.
     *
     * @param FormInterface $form The form to submit.
     * @param mixed $request The current request.
     */
    public function handleRequest(FormInterface $form, $request = null)
    {
        if ($request instanceof Request && $request->getMethod() === 'GET') {
            $parameters = explode('/', urldecode($request->getPathInfo()));
            $data = array_filter(
                array_map(
                    function($value) {
                        return $value instanceof Form ? null : false;
                    },
                    $form->all()
                ),
                function($value) {
                    return $value !== false;
                }
            );
            array_walk($data, function(&$value, $key) use ($parameters) {
                if (($keyPosition = array_search($key, $parameters))) {
                    $value = isset($parameters[$keyPosition + 1]) ? $parameters[$keyPosition + 1] : null;
                }
            });
            $form->submit($data);
            return;
        }

        $this->decoratedHandler->handleRequest($form);
    }
}