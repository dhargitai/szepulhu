<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Exception;
use Behat\Mink\Exception\ExpectationException;
use Behat\Mink\Session;

/**
 * Class ElementFoundException
 *
 * This exception indicates that there is an element on the page which should not be present.
 *
 * @package Exception
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class ElementFoundException extends ExpectationException
{
    /**
     * Initializes exception.
     *
     * @param Session $session  session instance
     * @param string  $type     element type
     * @param string  $selector element selector type
     * @param string  $locator  element locator
     */
    public function __construct(Session $session, $type = null, $selector = null, $locator = null)
    {
        $message = '';

        if (null !== $type) {
            $message .= ucfirst($type);
        } else {
            $message .= 'Tag';
        }

        if (null !== $locator) {
            if (null === $selector || in_array($selector, array('css', 'xpath'))) {
                $selector = 'matching '.($selector ?: 'locator');
            } else {
                $selector = 'with '.$selector;
            }
            $message .= ' '.$selector.' "'.$locator.'"';
        }

        $message .= ' found, but not expected.';

        parent::__construct($message, $session);
    }
}