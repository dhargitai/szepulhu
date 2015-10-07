<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Clients;

use Page\CustomPage;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;

/**
 * Class Logout
 * @package Page\Clients
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class Logout extends CustomPage
{
    protected $path = '/logout';

    /**
     * Check if current page matches the expected one.
     *
     * After logout the client is redirected to the homepage.
     *
     * @param array $urlParameters
     */
    protected function verifyUrl(array $urlParameters = array())
    {
        if ($this->getSession()->getCurrentUrl() !== $this->getHomePageUrl()) {
            throw new UnexpectedPageException(
                sprintf('Expected to be on homepage but found "%s" instead.', $this->getSession()->getCurrentUrl())
            );
        }
    }

    private function getHomePageUrl()
    {
        return $this->getPage('Homepage')->getUrl();
    }
}