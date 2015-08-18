<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Element\Clients\Navigation;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;


/**
 * Class TopMenu
 *
 * This is the top navigation menu for logged in clients.
 *
 * @package Page\Element\Clients\Navigation
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class TopMenu extends Element
{
    protected $selector = ['css' => 'header nav#client-menu'];
}