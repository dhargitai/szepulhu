<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Behat\Behat\Context\Context;
use Page\Clients\Logout;

/**
 * Class HeaderContext
 *
 * This context encapsulates all steps which manipulate the header of a page.
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class HeaderContext implements Context
{
    /** @var Logout $loginPage */
    private $logoutPage;

    /**
     * Constructor.
     *
     * @param Logout $logoutPage
     */
    public function __construct(Logout $logoutPage)
    {
        $this->logoutPage = $logoutPage;
    }

    /**
     * @Given /^I am logged out$/
     */
    public function iAmLoggedOut()
    {
        $this->logoutPage->open();
    }
}