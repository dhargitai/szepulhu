<?php
/**
 * A common, customized parent for some page object which reveals the path
 * so the linking to them can be used in feature files in a more centralized way.
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.23.
 * @package   szepulhu_functional_tests
 */

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

abstract class CustomPage extends Page
{
    /**
     * @return string
     */
    public function getUrlPath()
    {
        return $this->path;
    }
}
