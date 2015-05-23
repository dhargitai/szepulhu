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
        $this->homepage->open();
        $this->homepage->selectOneOfTheFeaturedProfessionals();
    }

    /**
     * @Given I visit a professional's salon page
     */
    public function iVisitAProfessionalSSalonPage()
    {
        $this->homepage->open();
        $this->homepage->selectOneOfTheFeaturedProfessionals();
        $this->professionalProfile->openTheSalon();
    }
}
