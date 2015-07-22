<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Application\Form;


use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\NativeRequestHandler;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SeoRequestHandlerSpec
 *
 * @package spec\Application\Form
 * @author Geza Buza <bghome@gmail.com>
 */
class SeoRequestHandlerSpec extends ObjectBehavior
{
    function let(NativeRequestHandler $nativeRequestHandler, FormInterface $form, Request $request)
    {
        $this->initRequestDouble($request);
        $this->initFormDouble($form);
        $this->beConstructedWith($nativeRequestHandler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Form\SeoRequestHandler');
    }

    function it_decorates_native_request_handler_object(
        NativeRequestHandler $nativeRequestHandler, FormInterface $form, Request $request
    ) {
        $request->getMethod()->willReturn('GET');
        $nativeRequestHandler->handleRequest(Argument::cetera())->shouldNotBeCalled();

        $this->handleRequest($form, $request);

        $request->getMethod()->willReturn('POST');
        $nativeRequestHandler->handleRequest(Argument::cetera())->shouldBeCalled();

        $this->handleRequest($form, $request);
    }

    function it_parses_seo_friendly_url(
        FormInterface $form, Request $request, Form $color, Form $houseNumber, SubmitButton $button
    ) {
        $request->getPathInfo()->willReturn('/do-something/color/vivid%20green/house_number/10/submit/true');
        $form->all()->willReturn([
            'color' => $color,
            'house_number' => $houseNumber,
            'submit' => $button,
        ]);

        $form->submit(['color' => 'vivid green', 'house_number' => 10])->shouldBeCalled();

        $this->handleRequest($form, $request);
    }

    private function initRequestDouble(Request $request)
    {
        $request->getMethod()->willReturn('GET');
        $request->getPathInfo()->willReturn('');
    }

    private function initFormDouble(FormInterface $form)
    {
        $form->all()->willReturn([]);
        $form->submit(Argument::type('array'))->willReturn($form);
    }
}
