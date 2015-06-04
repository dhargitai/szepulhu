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

    private $freeFeaturedProfessionalSlot;

    public function selectOneOfTheFeaturedProfessionals()
    {
        $this->find('css', '.featuredProfessional:first-child a')->click();
    }

    public function getSlugOfTheFirstFeaturedProfessional()
    {
        return ltrim($this->find('css', '.featuredProfessional:first-child a')->getAttribute('href'), '/');
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

    public function selectCounty($countyName)
    {
        $this->find('css', '#countySelector')->selectOption($countyName);
        $timeToWaitInMs = 30000;
        $this->getSession()->wait($timeToWaitInMs, '(0 === jQuery.active)');
    }

    public function hasFreeFeaturedProfessionalSlot()
    {
        $freeSlot = $this->getFreeFeaturedProfessionalSlot();
        return !is_null($freeSlot);
    }

    public function hasFirstFreeFeaturedProfessionalSlotSilhouette()
    {
        $freeSlot = $this->getFreeFeaturedProfessionalSlot();
        $xpathSelector = "//img[contains(@src, 'silhouette_male.jpg') or contains(@src, 'silhouette_female.jpg')]";
        $silhouette = $freeSlot->find('xpath', $xpathSelector);
        return !is_null($silhouette);
    }

    public function isFirstFreeFeaturedProfessionalSlotLinkingTo($href)
    {
        $freeSlot = $this->getFreeFeaturedProfessionalSlot();
        $xpathSelector = sprintf("//a[contains(@href, '%s')]", $href);
        $link = $freeSlot->find('xpath', $xpathSelector);
        return !is_null($link);
    }

    private function getFreeFeaturedProfessionalSlot()
    {
        if (!$this->freeFeaturedProfessionalSlot) {
            $this->freeFeaturedProfessionalSlot = $this->find('css', '.featuredProfessional.free:first-child');
        }
        return $this->freeFeaturedProfessionalSlot;
    }
}
