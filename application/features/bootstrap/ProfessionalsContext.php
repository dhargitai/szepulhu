<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Page\Homepage;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

/**
 * Class ProfessionalsContext
 *
 * This context makes interactions to the professional users and related functionality.
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class ProfessionalsContext implements Context
{
    private $homepage;

    /** @var Page $currentPage */
    private $currentPage;

    public function __construct(Homepage $homepage)
    {
        $this->homepage = $homepage;
    }

    /**
     * @Given /^I fill the search fields with the following properties$/
     */
    public function iFillTheSearchFieldsWithTheFollowingProperties(TableNode $table)
    {
        foreach ($table->getColumnsHash() as $row) {
            foreach ($row as $column => $value) {
                $this->homepage->fillSearchField($column, $value);
            }
        }
    }

    /**
     * @When /^I press the "([^"]*)" button$/
     */
    public function iPressTheButton($title)
    {
        $this->currentPage = $this->homepage->pressSearchFormButton($title);
    }

    /**
     * @Then /^I should see the search result page$/
     */
    public function iShouldSeeTheSearchResultPage()
    {
        $this->currentPage->isOpen();
    }

    /**
     * @Given /^I should see the list of matching professionals$/
     */
    public function iShouldSeeTheListOfMatchingProfessionals()
    {
        /** @var \Page\Professionals\SearchResult $currentPage  */
        $currentPage = $this->currentPage;
        $currentPage->getItems();
    }

    /**
     * @Given /^I leave the search form empty$/
     */
    public function iLeaveTheSearchFormEmpty()
    {
        $this->homepage->clearSearchForm();
    }

    /**
     * @Then /^I should see the message "([^"]*)"$/
     */
    public function iShouldSeeTheMessage($message)
    {
        $this->currentPage->hasContent($message);
    }

    /**
     * @Given /^I should not see any result$/
     */
    public function iShouldNotSeeAnyResult()
    {
        /** @var \Page\Professionals\SearchResult $currentPage  */
        $currentPage = $this->currentPage;
        $currentPage->hasNoItems();
    }

    /**
     * @Then /^I should see basic information about a list of featured professionals like$/
     */
    public function iShouldSeeBasicInformationAboutAListOfFeaturedProfessionalsLike(TableNode $table)
    {
        foreach ($table->getColumnsHash() as $row) {
            $this->homepage->ensureFeaturedProfessionalExist($row['Name'], $row['Profession'], $row['Photo']);
        }
    }
}