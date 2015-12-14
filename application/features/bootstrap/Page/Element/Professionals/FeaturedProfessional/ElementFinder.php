<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Element\Professionals\FeaturedProfessional;

use Geza\Behat\ElementFinderExtension\ElementFinder as FinderInterface;
use Geza\Behat\ElementFinderExtension\ElementFinderBuilder;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

/**
 * Class ElementFinder
 *
 * Find a specific featured professional element on a page.
 *
 * @package Page\Element\Professionals\ElementFinder
 * @author Geza Buza <bghome@gmail.com>
 */
class ElementFinder implements FinderInterface
{
    /** @var ElementFinderBuilder $elementFinder */
    private $elementFinder;

    public function __construct(ElementFinderBuilder $builder)
    {
        $this->elementFinder = $builder;
    }

    public function addNameFilter($name)
    {
        $this->elementFinder->matchClassWithContent('professionalName', $name);
    }

    public function addProfessionFilter($profession)
    {
        $this->elementFinder->matchClassWithContent('professionalProfession', $profession);
    }

    public function addPhotoFilter($photo)
    {
        $this->elementFinder->matchTagWithAttribute('img', 'title', $photo);
    }

    /**
     * {@inheritdoc}
     */
    public function find(Page $page)
    {
        $element = $page->find($this->elementFinder->getSelector(), $this->elementFinder->getLocator());
        if ($element === null) {
            throw new ElementNotFoundException('Featured professional does not exist.');
        }
        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public function elementExists(Page $page)
    {
        try {
            $this->find($page);
        } catch (ElementNotFoundException $e) {
            return false;
        }
        return true;
    }
}