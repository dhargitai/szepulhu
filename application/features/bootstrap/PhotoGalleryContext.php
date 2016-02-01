<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Page\ProfessionalProfile;

/**
 * Class PhotoGalleryContext
 *
 * This context interacts with the photo gallery carousel widget.
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class PhotoGalleryContext implements Context
{

    /** @var ProfessionalProfile $profilePage */
    private $profilePage;

    /** @var string $currentNavigationButton */
    private $currentNavigationButton;

    /** @var string $photoGalleryStateBefore */
    private $photoGalleryStateBefore;

    /** @var string $selectedImageTitle */
    private $selectedImageTitle;

    /**
     * PhotoGalleryContext constructor.
     *
     * @param ProfessionalProfile $profilePage
     */
    public function __construct(ProfessionalProfile $profilePage)
    {
        $this->profilePage = $profilePage;
    }

    /**
     * @Given I have a :direction arrow button
     */
    public function iHaveAnArrowButton($direction)
    {
        $this->currentNavigationButton = $direction;
        $this->photoGalleryStateBefore = $this->profilePage->getPhotoGalleryState();
    }

    /**
     * @When I click on it
     */
    public function iClickOnIt()
    {
        $this->profilePage->clickNavigationButton($this->currentNavigationButton);
    }

    /**
     * @Then I should see a new list of photos from the gallery
     */
    public function iShouldSeeANewListOfPhotosFromTheGallery()
    {
        if ($this->photoGalleryStateBefore === $this->profilePage->getPhotoGalleryState()) {
            throw new \RuntimeException('Photo gallery state has not changed.');
        }
    }

    /**
     * @When I click on any photo from the gallery
     */
    public function iClickOnAnyPhotoFromTheGallery()
    {
        $this->selectedImageTitle = $this->profilePage->getTitleOfNthPhoto(3);
        $this->profilePage->clickOnTheNthPhoto(3);
    }

    /**
     * @Then I should see that image opened in a modal window
     */
    public function iShouldSeeThatImageOpenedInTheGalleryBrowser()
    {
        if (!$this->profilePage->isPhotoModalWindowOpen()) {
            throw new UnexpectedPageException('The current page is expected to show the photo modal window.');
        }

        if ($this->selectedImageTitle !== $this->profilePage->getPhotoTitleInModalWindow()) {
            throw new ElementNotFoundException(
                sprintf(
                    'Large photo expected to have title "%s", but found "%s".',
                    $this->selectedImageTitle,
                    $this->profilePage->getPhotoTitleInModalWindow()
                )
            );
        }
    }

    /**
     * @Given I should have a :direction button
     */
    public function iShouldHaveAButton($direction)
    {
        if (!$this->profilePage->hasNavigationButton($direction)) {
            throw new ElementNotFoundException(sprintf('Photo gallery page has no "%s" button.', $direction));
        }
    }

    /**
     * @Given I see the photo gallery browser of :slug
     */
    public function iSeeThePhotoGalleryBrowserOf($slug)
    {
        $this->galleryPage->open(['slug' => $slug]);
        $this->selectedImageTitle = $this->galleryPage->getLargePhotoTitle();
    }

    /**
     * @When I click on the :direction arrow button
     */
    public function iClickOnTheArrowButton($direction)
    {
        $this->galleryPage->clickButton($direction);
    }

    /**
     * @Then I should see another photo from the gallery
     */
    public function iShouldSeeAnotherPhotoFromTheGallery()
    {
        if ($this->selectedImageTitle === $this->galleryPage->getLargePhotoTitle()) {
            throw new ElementNotFoundException(
                sprintf(
                    'Large photo expected to have different title than "%s".',
                    $this->selectedImageTitle
                )
            );
        }
    }
}