<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Professionals;

use Exception\ElementFoundException;
use Page\CustomPage;


/**
 * Class SearchResult
 *
 * This page contains the list of matched professional users.
 *
 * @package Page\Professionals
 * @author Geza Buza <bghome@gmail.com>
 */
class SearchResult extends CustomPage
{
    protected $path = '/service/search/{parameters}';

    protected $title = 'Book an Appointment';

    /**
     * @return \SensioLabs\Behat\PageObjectExtension\PageObject\Element[]
     * @throws \SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException
     */
    public function getItems()
    {
        return $this->getElements('Professionals\Result item');
    }

    public function hasNoItems()
    {
        if ($this->hasElement('Professionals\Result item')) {
            throw new ElementFoundException($this->getSession(), 'Result item');
        }
    }

    /**
     * @return \SensioLabs\Behat\PageObjectExtension\PageObject\Element
     * @throws \SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException
     */
    public function getFirstItem()
    {
        return $this->getElement('Professionals\Result item');
    }
}