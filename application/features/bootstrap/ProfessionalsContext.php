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
use Exception\PropertyNotFoundException;
use Page\Homepage;
use Page\Professionals\SearchResult;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Symfony\Component\DependencyInjection\Container;

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

    /** @var SearchResult $searchResultPage */
    private $searchResultPage;

    public function __construct(Homepage $homepage, SearchResult $searchResultPage)
    {
        $this->homepage = $homepage;
        $this->searchResultPage = $searchResultPage;
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
        /** @var SearchResult $currentPage  */
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
        /** @var SearchResult $currentPage  */
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

    /**
     * @Then I should be on the Book an Appointment page
     */
    public function iShouldBeOnTheSearchResultPage()
    {
        if (!$this->searchResultPage->isOpen()) {
            throw new UnexpectedPageException('The current page is expected to be the search result page.');
        }
        $this->searchResultPage->verifyTitle();
    }

    /**
     * @When I select the location :name on the search form
     */
    public function iSelectTheLocationOnTheSearchForm($name)
    {
        $this->homepage->selectLocationSearchParameter($name);
    }

    /**
     * @Then I should see basic information of a professional
     */
    public function iShouldSeeBasicInformationOfAProfessional(TableNode $table)
    {
        /** @var \Page\Element\Professionals\ResultItem $professionalElement */
        $professionalElement = $this->searchResultPage->getFirstItem();
        foreach ($table->getColumn(0) as $propertyName) {
            $methodName = Container::camelize('has_' . $propertyName);
            if (!method_exists($professionalElement, $methodName)) {
                throw new \RuntimeException(
                    sprintf('Cannot verify property "%s" of professional user.', $propertyName)
                );
            }

            if (!$professionalElement->$methodName()) {
                throw $this->createPropertyNotFoundException($professionalElement, $propertyName);
            }
        }
    }

    private function createPropertyNotFoundException(Element $element, $propertyName)
    {
        return new PropertyNotFoundException(
            sprintf('Element "%s" has no property "%s".', get_class($element), $propertyName)
        );
    }
}