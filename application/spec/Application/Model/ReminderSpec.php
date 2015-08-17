<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Application\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Application\Model\Reminder;

/**
 * Class ReminderSpec
 *
 * @package spec\Application\Model
 * @author Hargitai Dávid <div@diatigrah.hu>
 */
class ReminderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Model\Reminder');
        $this->shouldHaveType('Application\Model\ValueObject');
    }

    public function let()
    {
        $this->beConstructedWith(['type' => Reminder::TYPE_EMAIL]);
    }
}
