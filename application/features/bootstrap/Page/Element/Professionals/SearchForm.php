<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Element\Professionals;
use Behat\Mink\Element\NodeElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;


/**
 * Class SearchForm
 *
 * This element represents the professional service search form. Users can search for professional by filling in the
 * parameters.
 *
 * @package Page\Element\Professionals
 * @author Geza Buza <bghome@gmail.com>
 */
class SearchForm extends Element
{
    protected $selector = '#app_professional_search';

    public function clickOnButton($title)
    {
        $this->findButton($title)->click();
    }

    /**
     * Finds field (input, textarea, select) with specified locator.
     *
     * @param string $locator input id, name or label
     *
     * @return NodeElement|null
     */
    public function findField($locator)
    {
        if (($element = parent::findField($locator))) {
            return $element;
        }

        return $this->find(
            'css', sprintf('input[title="%1$s"],select[title="%1$s"],textarea[title="%1$s"]', addslashes($locator))
        );
    }
}