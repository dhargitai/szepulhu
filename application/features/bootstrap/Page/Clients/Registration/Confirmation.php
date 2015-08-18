<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Clients\Registration;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;


/**
 * Class Confirmation
 *
 * This is the successful client registration confirmation page.
 *
 * @package Page\Clients\Registration
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class Confirmation extends Page
{
    protected $path = '/registration/confirmed';
}