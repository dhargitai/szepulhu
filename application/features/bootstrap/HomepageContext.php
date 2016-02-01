<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Application\Entity\ProfessionalUserRepository;
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
class HomepageContext extends PageObjectContext implements Context, SnippetAcceptingContext
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

    /** @var ProfessionalUserRepository $professionalUserRepository */
    private $professionalUserRepository;

    public function __construct(
        Homepage $homepage, ProfessionalProfile $professionalProfile,
        ProfessionalUserRepository $professionalUserRepository
    ) {
        $this->homepage = $homepage;
        $this->professionalProfile = $professionalProfile;
        $this->professionalUserRepository = $professionalUserRepository;
    }

    /**
     * @When I go to the homepage
     */
    public function iGoToTheHomepage()
    {
        $this->homepage->open();
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
            array('slug' => $professionalSlug)
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
     * @When I select :name county in the location selector
     * @When I select :name city in the location selector
     */
    public function iSelectTheLocation($name)
    {
        $this->homepage->selectLocationOfFeaturedProfessionals($name);
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
        $this->homepage->getSession()->executeScript("Application.geolocateClosestFeaturedProfessionals($('select[name=locationSelector]'));");
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

    /**
     * @Then I should see only professionals from :countyName county
     *
     * @param $countyName
     */
    public function iShouldSeeOnlyProfessionalsFromCounty($countyName)
    {
        $expectedUserIds = array_map(
            function($value){
                return $value['id'];
            },
            $this->findAllProfessionalUserByCounty($countyName)
        );
        $currentUserIds = $this->homepage->getFeaturedProfessionalsIds();

        if ($missingIds = array_diff($expectedUserIds, $currentUserIds)) {
            throw new DomainException(
                'These professional users must be on the page, but missing: ' . implode(',', $missingIds)
            );
        }
        if ($extraUserIds = array_diff($currentUserIds, $expectedUserIds)) {
            throw new DomainException(
                'These professional users should not be on the page, but present: ' . implode(',', $extraUserIds)
            );
        }
    }

    private function findAllProfessionalUserByCounty($countyName)
    {
        $query = $this->professionalUserRepository->createQueryBuilder('u')
            ->select('u.id')
            ->join('u.city', 'c')
            ->join('c.county', 'co', \Doctrine\ORM\Query\Expr\Join::WITH, 'co.name = :countyName')
            ->where('u.enabled = :yes')
            ->andwhere('u.featuredFrom <= CURRENT_TIME()')
            ->andWhere('u.featuredTo >= CURRENT_TIME()')
            ->andWhere('c.isBigCity <> :yes')
            ->andWhere('c.isCapital <> :yes')
            ->setParameters(['yes' => 1, 'countyName' => $countyName])
            ->getQuery();

        return $query->getArrayResult();
    }
}
