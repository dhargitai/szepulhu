<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Page\Clients\Login;
use Page\Clients\Registration;
use Page\Clients\Registration\Confirmation;
use Page\Homepage;
use PhpSpec\Exception\Example\PendingException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;

/**
 * Class ClientsContext
 *
 * This context class represents all method that a client can do on the frontend.
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class ClientsContext implements Context
{
    /** @var Registration $registrationPage */
    private $registrationPage;

    /** @var Homepage $homepage */
    private $homepage;

    /** @var Confirmation $confirmationPage */
    private $confirmationPage;

    /** @var Login $loginPage */
    private $loginPage;

    /** @var RawMinkContext $minkContext */
    private $minkContext;

    public function __construct(
        Registration $registrationPage, Homepage $homepage, Confirmation $confirmationPage, Login $loginPage
    ) {
        $this->registrationPage = $registrationPage;
        $this->homepage = $homepage;
        $this->confirmationPage = $confirmationPage;
        $this->loginPage = $loginPage;
    }

    /**
     * @BeforeScenario
     */
    public function gatherMinkContext(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();
        $this->minkContext = $environment->getContext('Behat\MinkExtension\Context\RawMinkContext');
    }

    /**
     * @Given /^I am on the client registration page$/
     */
    public function iAmOnTheClientRegistrationPage()
    {
        $this->registrationPage->open();
    }

    /**
     * @Given /^I fill in the form with these data$/
     * @param TableNode $table
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iFillInTheFormWithTheseData(TableNode $table)
    {
        $registrationPage = $this->registrationPage;
        foreach ($table->getColumnsHash() as $row) {
            $registrationPage->fillRegistrationFormField($row['Field'], $row['Value']);
        }
    }

    /**
     * @When /^I submit the registration form$/
     */
    public function iSubmitTheRegistrationForm()
    {
        $this->registrationPage->submitRegistration();
    }

    /**
     * @Then /^I should not proceed with the process$/
     */
    public function iShouldNotProceedWithTheProcess()
    {
        if (!$this->registrationPage->isOpen()) {
            throw new UnexpectedPageException('The current page is expected to be the client registration page.');
        }
    }

    /**
     * @Given /^I should see error messages next to the input fields$/
     * @param TableNode $table
     * @throws PendingException
     */
    public function iShouldSeeErrorMessagesNextToTheInputFields(TableNode $table)
    {
        foreach ($table->getColumnsHash() as $row) {
            if (!empty($row['Message'])) {
                $this->registrationPage->ensureFieldHasError($row['Field'], $row['Message']);
            }
        }
    }

    /**
     * @Then /^I should be redirected to the registration confirmation page$/
     */
    public function iShouldBeRedirectedToTheRegistrationConfirmationPage()
    {
        if (!$this->confirmationPage->isOpen()) {
            throw new UnexpectedPageException('The current page is expected to be the registration confirmation page.');
        }
    }

    /**
     * @Given /^I should see the navigation menu for registered clients$/
     */
    public function iShouldSeeTheNavigationMenuForRegisteredClients()
    {
        $this->homepage->ensureClientNavigationMenuPresent();
    }

    /**
     * @Given /^I am on the client login page$/
     */
    public function iAmOnTheClientLoginPage()
    {
        $this->minkContext->getMink()->resetSessions();

        $this->loginPage->open();
    }

    /**
     * @When /^I log in with "([^"]*)" and "([^"]*)"$/
     */
    public function iLogInWith($email, $password)
    {
        $this->loginPage->fillUsername($email);
        $this->loginPage->fillPassword($password);
        $this->loginPage->doLogin();
    }

    /**
     * @Then /^I should see the message "([^"]*)"$/
     */
    public function iShouldSeeTheMessage($message)
    {
        $this->homepage->hasContent($message);
    }

    /**
     * @Given /^I am logged in as "([^"]*)" and "([^"]*)"$/
     */
    public function iAmLoggedInAs($email, $password)
    {
        $this->iAmOnTheClientLoginPage();
        $this->iLogInWith($email, $password);
    }

    /**
     * @When /^I click on the "([^"]*)" link$/
     */
    public function iClickOnTheLink($href)
    {
        $this->homepage->clickLink($href);
    }

    /**
     * @Then /^I should see the "([^"]*)" link$/
     */
    public function iShouldSeeTheLink($href)
    {
        $this->homepage->findLink($href);
    }
}