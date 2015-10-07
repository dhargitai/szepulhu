<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Geza\Behat\ElementFinderExtension;

use Behat\Mink\Element\Element;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class XPathFinderBuilderSpec
 *
 * Unit test of the XPathFinderBuilderSpec class.
 *
 * @package spec\Geza\Behat\MatcherExtension
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class XPathFinderBuilderSpec extends ObjectBehavior
{
    function let(Element $element)
    {
        $this->beConstructedWith($element);

        $this->initElementDouble($element);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Geza\Behat\ElementFinderExtension\XPathFinderBuilder');
    }

    function it_returns_selector_type()
    {
        $this->getSelector()->shouldReturn('xpath');
    }

    function it_returns_element_locator_without_filters(Element $element)
    {
        $element->getXpath()->willReturn('/bar');

        $this->getLocator()->shouldReturn('/bar');
    }

    function it_returns_locator_when_class_filter_is_applied_once()
    {
        $this->matchClassWithContent('paragraph', 'lorem ipsum')->shouldReturn($this);

        $this->getLocator()->shouldReturn(
            "/foo".                                                            // element selector
            "//*[contains(@class,'paragraph') ".
                "and contains(descendant-or-self::text(), 'lorem ipsum')]".    // filter condition
            "/ancestor::foo"                                                   // go back to element level
        );
    }

    function it_returns_locator_when_class_filter_is_applied_multiple_times()
    {
        $this->matchClassWithContent('paragraph', 'lorem')->shouldReturn($this);
        $this->matchClassWithContent('label', 'ipsum')->shouldReturn($this);

        $this->getLocator()->shouldReturn(
            "/foo".                                                     // element selector
            "//*[contains(@class,'paragraph') ".
                "and contains(descendant-or-self::text(), 'lorem')]".   // filter condition 1
            "/ancestor::foo".                                           // go back to element level
            "//*[contains(@class,'label') ".
                "and contains(descendant-or-self::text(), 'ipsum')]".   // filter condition 2
            "/ancestor::foo"                                            // go back to element level
        );
    }

    function it_returns_locator_when_tag_filter_is_applied_once()
    {
        $this->matchTagWithAttribute('img', 'src', 'foobar.jpg')->shouldReturn($this);

        $this->getLocator()->shouldReturn(
            "/foo".                         // element selector
            "//img[@src='foobar.jpg']".     // filter condition
            "/ancestor::foo"                // go back to element level
        );
    }

    function it_returns_locator_when_tag_filter_is_applied_multiple_times()
    {
        $this->matchTagWithAttribute('img', 'src', 'foobar.jpg')->shouldReturn($this);
        $this->matchTagWithAttribute('a', 'href', 'https://foobar.net')->shouldReturn($this);

        $this->getLocator()->shouldReturn(
            "/foo".                                 // element selector
            "//img[@src='foobar.jpg']".             // filter condition 1
            "/ancestor::foo".                       // go back to element level
            "//a[@href='https://foobar.net']".      // filter condition 2
            "/ancestor::foo"                        // go back to element level
        );
    }

    function it_returns_locator_when_all_filter_types_are_applies_multiple_times()
    {
        $this->matchClassWithContent('paragraph', 'lorem')->shouldReturn($this);
        $this->matchTagWithAttribute('img', 'src', 'foobar.jpg')->shouldReturn($this);
        $this->matchTagWithAttribute('a', 'href', 'https://foobar.net')->shouldReturn($this);
        $this->matchClassWithContent('label', 'ipsum')->shouldReturn($this);

        $this->getLocator()->shouldReturn(
            "/foo".                                                             // element selector
            "//*[contains(@class,'paragraph') ".
                "and contains(descendant-or-self::text(), 'lorem')]".           // class filter condition 1
            "/ancestor::foo".                                                   // go back to element level
            "//img[@src='foobar.jpg']".                                         // tag filter condition 1
            "/ancestor::foo".                                                   // go back to element level
            "//a[@href='https://foobar.net']".                                  // tag filter condition 2
            "/ancestor::foo".                                                   // go back to element level
            "//*[contains(@class,'label') ".
                "and contains(descendant-or-self::text(), 'ipsum')]".           // class filter condition 2
            "/ancestor::foo"                                                    // go back to element level
        );
    }

    function it_returns_locator_containing_ancestor_reference_to_element(Element $element)
    {
        $element->getXpath()->willReturn('//html/descendant-or-self::*');
        $this->matchTagWithAttribute('img', 'src', 'foobar.jpg')->shouldReturn($this);

        $this->getLocator()->shouldReturn(
            "//html/descendant-or-self::*" .    // element selector
            "//img[@src='foobar.jpg']".         // filter condition
            "/ancestor::*"                      // go back to element level
        );
    }

    private function initElementDouble(Element $element)
    {
        $element->getXpath()->willReturn('/foo');
    }
}
