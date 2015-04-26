<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\MinkContext;
use Page\Homepage;
use Page\ProfessionalProfile;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
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
     * @When I go to one of the featured professionals
     */
    public function iGoToOneOfTheFeaturedProfessionals()
    {
        $this->homepage->selectOneOfTheFeaturedProfessionals();
    }

    /**
     * @When I go to its salon
     */
    public function iGoToItsSalon()
    {
        $this->professionalProfile->openTheSalon();
    }
}
