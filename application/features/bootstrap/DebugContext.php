<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Behat\Testwork\Tester\Result\TestResult;

/**
 * Class DebugContext
 *
 * This class is responsible for providing debug information to the developer about the running Behat tests.
 * It also can help configuring the web browser used for testing.
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class DebugContext implements Context
{
    use KernelDictionary;

    const TAG_TAKE_SCREENSHOT_AFTER_EVERY_STEP = 'debug_step';

    const MAX_FILENAME_LENGTH = 255;

    /** @var \Behat\MinkExtension\Context\MinkContext */
    private $minkContext;

    /** @var int $screenWidth Desired browser window width */
    protected $screenWidth;

    /** @var int $screenHeight Desired browser window height */
    protected $screenHeight;

    /**
     * Constructor
     *
     * @param string $windowResolution Desired browser window resolution in "1366x768" format
     */
    public function __construct($windowResolution)
    {
        $resolution = explode('x', $windowResolution);
        $this->screenWidth = $resolution[0];
        $this->screenHeight = $resolution[1];
    }

    /**
     * @BeforeScenario
     */
    public function gatherMinkContext(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->minkContext = $environment->getContext('Behat\MinkExtension\Context\RawMinkContext');
        $this->minkContext->getSession()->resizeWindow($this->screenWidth, $this->screenHeight);
    }
}