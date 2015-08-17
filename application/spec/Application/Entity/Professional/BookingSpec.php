<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Application\Entity\Professional;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * BookingSpec
 *
 * @package spec\Application\Entity
 * @author Hargitai Dávid <div@diatigrah.hu>
 */
class BookingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Entity\Professional\Booking');
    }
}
