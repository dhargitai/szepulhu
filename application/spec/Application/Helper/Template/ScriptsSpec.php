<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Application\Helper\Template;

use PhpSpec\ObjectBehavior;

/**
 * Class ScriptsSpec
 * @package spec\Application\Helper\Template
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class ScriptsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Helper\Template\Scripts');
    }

    function it_returns_added_scripts()
    {
        $this->add('<script>//foo</script>');
        $this->add('<script>//bar</script>');
        $this->__toString()->shouldReturn("<script>//foo</script>\n<script>//bar</script>");
    }

    function it_returns_scripts_sorted()
    {
        $firstScript = '<script>//foo</script>';
        $secondScript = '<script>//bar</script>';
        $thirdScript = '<script>//baz</script>';

        $this->add($secondScript, 2);
        $this->add($thirdScript);
        $this->add($firstScript, 1);

        $this->__toString()->shouldReturn("$firstScript\n$secondScript\n$thirdScript");
    }

    function it_adds_specified_script_only_once()
    {
        $firstScript = '<script>//foo</script>';
        $secondScript = '<script>//bar</script>';

        $this->add($firstScript);
        $this->add($firstScript);
        $this->addOnce($firstScript);
        $this->addOnce($secondScript);
        $this->addOnce($secondScript);

        $this->__toString()->shouldReturn("$firstScript\n$firstScript\n$secondScript");
    }

    function it_reports_empty_status()
    {
        $this->isEmpty()->shouldReturn(true);

        $this->add('<script>//foo</script>');
        $this->isEmpty()->shouldReturn(false);
    }

    function it_can_strip_script_tags()
    {
        $stripScriptTags = true;
        $this->beConstructedWith($stripScriptTags);

        $this->add('<script>//foo</script>');

        $this->__toString()->shouldReturn('//foo');
    }
}
