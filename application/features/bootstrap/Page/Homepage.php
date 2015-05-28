<?php
/**
 *
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.23.
 * @package   szepulhu_functional_tests
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

    public function getSlugOfTheFirstFeaturedProfessional()
    {
        return $this->find('css', '.featuredProfessional:first-child a')->getAttribute('href');
    }

    public function hasMenuItemInNavigation($label, $targetPath)
    {
        $xpathSelector = sprintf(
            "//nav[@role='navigation']//a[contains(text(),'%s') and contains(@href,'%s')]",
            $label,
            $targetPath
        );
        $menuItem = $this->find('xpath', $xpathSelector);
        return !is_null($menuItem);
    }

    public function hasFreeFeaturedProfessionalSlot()
    {
        $firstFreeSlot = $this->find('css', '.featuredProfessional.free:first-child');
        return !is_null($firstFreeSlot);
    }
}
