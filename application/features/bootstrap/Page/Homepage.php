<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page;

use Page\Element\Professionals\FeaturedProfessional;
use Page\Element\Professionals\FeaturedProfessional\ElementFinder;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;

/**
 * Class Homepage
 *
 * This is the start page of the application.
 *
 * @package Page
 * @author Dávid Hargitai <div@diatigrah.hu>
 * @author Geza Buza <bghome@gmail.com>
 */
class Homepage extends CustomPage
{
    /**
     * @var string $path
     */
    protected $path = '/';

    protected $elements = [
        'featured_professionals' => ['xpath' => "//*[contains(@class, 'featuredProfessional')]"],
    ];

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
            "//header[@role='navigation']//a[contains(text(),'%s') and contains(@href,'%s')]",
            $label,
            $targetPath
        );
        $menuItem = $this->find('xpath', $xpathSelector);
        return !is_null($menuItem);
    }

    public function selectLocation($locationName)
    {
        $this->find('css', '#locationSelector')->selectOption($locationName);
        $this->waitForAjax();
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

    public function ensureFeaturedProfessionalExist($name, $profession, $photo)
    {
        /** @var FeaturedProfessional $featuredProfessional */
        $featuredProfessional = $this->getElement('Professionals\Featured Professional');

        /** @var ElementFinder $finder */
        $finder = $featuredProfessional->getElementFinder();
        $finder->addNameFilter($name);
        $finder->addProfessionFilter($profession);
        $finder->addPhotoFilter($photo);
        $finder->find($this);
    }

    public function fillSearchField($label, $value)
    {
        $this->getSearchForm()->fillField($label, $value);
    }

    public function pressSearchFormButton($title)
    {
        $this->getSearchForm()->clickOnButton($title);
        return $this->getPage('Professionals\Search result');
    }

    /**
     * @return \Page\Element\Professionals\SearchForm
     */
    protected function getSearchForm()
    {
        return $this->getElement('Professionals\Search form');
    }

    private function getFreeFeaturedProfessionalSlot()
    {
        if (!$this->freeFeaturedProfessionalSlot) {
            $this->freeFeaturedProfessionalSlot = $this->find('css', '.featuredProfessional.free:first-child');
        }
        return $this->freeFeaturedProfessionalSlot;
    }

    public function isLocationSelected($locationName)
    {
        return $this->getSelectedLocation() === $locationName;
    }

    public function getSelectedLocation()
    {
        return $this->find('css', '#locationSelector')->getValue();
    }

    public function clearSearchForm()
    {
        $this->getSearchForm()->clear();
    }

    public function ensureClientNavigationMenuPresent()
    {
        if (!$this->getElement('Clients\Navigation\Top menu')->isValid()) {
            throw new ElementNotFoundException('Client top menu on current page does not found.');
        }
    }

    /**
     * @return array List of user IDs.
     */
    public function getFeaturedProfessionalsIds()
    {
        $userIds = [];
        foreach ($this->getElements('featured_professionals') as $user) {
            if ($user->hasAttribute('data-id')) {
                $userIds[] = $user->getAttribute('data-id');
            }
        }
        return $userIds;
    }
}
