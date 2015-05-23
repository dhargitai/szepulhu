<?php
/**
 * Created by PhpStorm.
 * User: hargitaidavid
 * Date: 2015.02.12.
 * Time: 22:52
 */

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class Homepage extends Page
{
    /**
     * @var string $path
     */
    protected $path = '/';

    public function selectOneOfTheFeaturedProfessionals()
    {
        $this->find('css', '.featuredProfessional:first-child a')->click();
    }

    public function hasMenuItemInNavigation($label)
    {
        $xpathSelector = sprintf(
            "//nav[@role='navigation']//a[contains(text(),'%s')]",
            $label
        );
        $menuItem = $this->find('xpath', $xpathSelector);
        return !is_null($menuItem);
    }

    public function getPageAfterFollowingLink($locator)
    {

    }
}
