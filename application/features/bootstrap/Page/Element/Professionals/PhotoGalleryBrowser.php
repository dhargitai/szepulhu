
namespace Page\Element\Professionals;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;


/**
 * Class PhotoGallery
 * @package Page\Element\Professionals
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class PhotoGallery extends Element
{
    protected $selector = '#professionalGallery';

    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function clickLeftArrow()
    {
        $this->pressButton('Previous');
    }

    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function clickRightArrow()
    {
        $this->pressButton('Next');
    }

    /**
     * @param int $position
     */
    public function clickPhoto($position)
    {
         $this->findNthPhoto($position)->click();
    }

    /**
     * @param int $position
     * @return Element
     */
    protected function findNthPhoto($position)
    {
        $currentPosition = 1;

        /** @var Element $photoLink */
        foreach ($this->findAll('css', 'div.columns a') as $photoLink) {
            if ($photoLink->isVisible() && $currentPosition++ === $position) {
                return $photoLink;
            }
        }

        throw new ElementNotFoundException(sprintf('Photo gallery has no visible image at position %d.', $position));
    }

    public function clickPreviousButton()
    {
        $this->pressButton('Previous');
    }

    public function clickNextButton()
    {
        $this->pressButton('Next');
    }
}