<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Page\Homepage;
use Page\ProfessionalProfile;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends PageObjectContext implements Context, SnippetAcceptingContext
{
    use KernelDictionary;

    /**
     * @var Homepage
     */
    private $homepage;

    /**
     * @var ProfessionalProfile
     */
    private $professionalProfile;

    public function __construct(Homepage $homepage, ProfessionalProfile $professionalProfile)
    {
        $this->homepage = $homepage;
        $this->professionalProfile = $professionalProfile;
    }

    /**
     * @Then I should see the following navigation links:
     *
     * @param TableNode $table
     */
    public function iShouldSeeTheFollowingNavigationLinks(TableNode $table)
    {
        foreach ($table as $row) {
            $targetPath = $this->getPage($row['target page'])->getUrlPath();
            if (!$this->homepage->hasMenuItemInNavigation($row['label'], $targetPath)) {
                $message = sprintf('Element "%s" not found.', $row['label']);
                throw new LogicException($message);
            }
        }
    }

    /**
     * @Given I visit the homepage
     * @Given I am on the homepage
     */
    public function iVisitTheHomepage()
    {
        $this->homepage->open();
    }

    /**
     * @Given I visit a professional's profile page
     */
    public function iVisitAProfessionalSProfilePage()
    {
        $this->iVisitTheHomepage();
        $professionalSlug = $this->homepage->getSlugOfTheFirstFeaturedProfessional();
        $this->professionalProfile->open(
            array('professionalSlug' => $professionalSlug)
        );
    }

    /**
     * @Given I visit a professional's salon page
     */
    public function iVisitAProfessionalSSalonPage()
    {
        $this->iVisitAProfessionalSProfilePage();
        $salonSlug = $this->professionalProfile->getSlugOfTheSalon();
        $this->getPage('Salon')->open(
            array('slug' => $salonSlug)
        );
    }

    /**
     * @When I select :countyName county in the location selector
     */
    public function iSelectCountyInTheLocationSelector($countyName)
    {
        $this->homepage->selectLocation($countyName);
    }

    /**
     * @When there isn't enough featured professionals to fill all the slots
     */
    public function thereIsnTEnoughFeaturedProfessionalsToFillAllTheSlots()
    {
        if (!$this->homepage->hasFreeFeaturedProfessionalSlot()) {
            throw new LogicException("There's no any free featured professional slot.");
        }
    }

    /**
     * @Then I should see silhouettes on the empty spaces linking to :professionalsSalesPage
     */
    public function iShouldSeeSilhouettesOnTheEmptySpacesLinkingTo($professionalsSalesPage)
    {
        if (!$this->homepage->hasFirstFreeFeaturedProfessionalSlotSilhouette()) {
            throw new LogicException("There's no silhouette image in the free featured professional slot.");
        }

        if (!$this->homepage->isFirstFreeFeaturedProfessionalSlotLinkingTo($professionalsSalesPage)) {
            $message = sprintf(
                "There's no link pointing to '%s' in the free featured professional slot.",
                $professionalsSalesPage
            );
            throw new LogicException($message);
        }
    }

    /**
     * @Then I shouldn't see any free featured professional slot
     */
    public function iShouldnTSeeAnyFreeFeaturedProfessionalSlot()
    {
        if ($this->homepage->hasFreeFeaturedProfessionalSlot()) {
            $message = "There's a free featured professional slot under the county where it shouldn't be.";
            throw new LogicException($message);
        }
    }

    /**
     * @Given the user shared his location's coordinates :latitude as latitude and :longitude as longitude
     */
    public function theUserSharedHisLocationSCoordinates($latitude, $longitude)
    {
        $javascript = "
            Application.init({
                geolocationAdapter: new Application.Geolocation.DummyAdapter('$latitude', '$longitude')
            })
        ";
        $this->homepage->getSession()->executeScript($javascript);
    }

    /**
     * @Given we stored :locationName :locationType as nearest featured professional location earlier
     */
    public function weStoredAsNearestFeaturedProfessionalLocationEarlier($locationName, $locationType)
    {
        $location = json_encode(
            [
                'name' => $locationName,
                'type' => $locationType,
            ],
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        );
        $javascript = 'Cookies.set("location", ' . $location . ');';
        $this->homepage->getSession()->executeScript($javascript);
    }

    /**
     * @When I wait for the featured professionals block's changing
     */
    public function iWaitForTheFeaturedProfessionalsBlockSChanging()
    {
        $this->homepage->getSession()->executeScript('Application.geolocateClosestFeaturedProfessionals();');
        $this->homepage->waitForAjax();
    }

    /**
     * @Then I should see :location in the location selector as nearest location
     */
    public function iShouldSeeInTheLocationSelectorAsNearestLocation($location)
    {
        if (!$this->homepage->isLocationSelected($location)) {
            $message = sprintf(
                "The '%s' location is expected in the location selector, but '%s' is selected instead.",
                $location,
                $this->homepage->getSelectedLocation()
            );
            throw new LogicException($message);
        }
    }
}
