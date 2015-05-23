<?php
/**
 *
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.23.
 * @package   szepulhu_
 */

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class ListYourBusiness extends Page
{
    /**
     * @var string $path
     */
    protected $path = '/vallalkozasoknak';

    /**
     * @var string $title
     */
    protected $title = 'Hirdesd a vállalkozásod';
}
