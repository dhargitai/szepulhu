<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Professionals;
use Exception\ElementFoundException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;


/**
 * Class SearchResult
 *
 * This page contains the list of matched professional users.
 *
 * @package Page\Professionals
 * @author Geza Buza <bghome@gmail.com>
 */
class SearchResult extends Page
{
    protected $path = '/service/search';

    public function getItems()
    {
        return $this->getElement('Professionals\Result item');
    }

    public function hasNoItems()
    {
        if ($this->hasElement('Professionals\Result item')) {
            throw new ElementFoundException($this->getSession(), 'Result item');
        }
    }
}