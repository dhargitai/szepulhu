<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Element\Professionals;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;


/**
 * Class ResultItem
 *
 * This element represents one or more matched professional user items.
 *
 * @package Page\Element\Professionals
 * @author Geza Buza <bghome@gmail.com>
 */
class ResultItem extends Element
{
    protected $selector = 'div.professional';
}