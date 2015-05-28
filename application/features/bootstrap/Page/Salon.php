<?php
/**
 *
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.23.
 * @package   szepulhu_functional_tests
 */

namespace Page;

use Behat\Mink\Exception\ElementNotFoundException;

class Salon extends CustomPage
{
    /**
     * @var string $path
     */
    protected $path = '/{slug}';

}
