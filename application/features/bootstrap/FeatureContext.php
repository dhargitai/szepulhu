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
     * @When I select :countyName county in the county selector
     */
    public function iSelectCountyInTheCountySelector($countyName)
    {
        $this->homepage->selectCounty($countyName);
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
     * @When my location is in one of the country's county
     */
    public function myLocationIsInOneOfTheCountrySCounty()
    {
        throw new PendingException();
    }

    /**
     * @When there are featured professionals in the current county
     */
    public function thereAreFeaturedProfessionalsInTheCurrentCounty()
    {
        throw new PendingException();
    }

    /**
     * @Then I should see featured professionals from my location's county
     */
    public function iShouldSeeFeaturedProfessionalsFromMyLocationSCounty()
    {
        throw new PendingException();
    }

    /**
     * @Then the county selector should be on the county of :arg1
     */
    public function theCountySelectorShouldBeOnTheCountyOf($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When my location is outside of the current country
     */
    public function myLocationIsOutsideOfTheCurrentCountry()
    {
        throw new PendingException();
    }

    /**
     * @When there are featured professionals in the capital's county
     */
    public function thereAreFeaturedProfessionalsInTheCapitalSCounty()
    {
        throw new PendingException();
    }

    /**
     * @Then I should see featured professionals from the capital's county
     */
    public function iShouldSeeFeaturedProfessionalsFromTheCapitalSCounty()
    {
        throw new PendingException();
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
}
