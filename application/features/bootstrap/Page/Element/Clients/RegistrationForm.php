<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Element\Clients;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;


/**
 * Class RegistrationForm
 *
 * This is the client registration form element.
 *
 * @package Page\Element\Clients
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class RegistrationForm extends Element
{
    protected $selector = ['css' => 'form[name=registration]'];

    /**
     * @param string $field Locator string.
     * @param string $message Expected error message.
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function ensureFieldHasError($field, $message)
    {
        $errorElements = $this->findField($field)->getParent()->findAll('css', 'ul>li');
        if (empty($errorElements)) {
            throw $this->elementNotFound(
                sprintf('Field "%s" expected to have error "%s" with', $field, $message), 'css', 'ul>li'
            );
        }

        $errorFound = false;
        foreach ($errorElements as $errorElement) {
            if ($errorElement->getText() === $message) {
                $errorFound = true;
                break;
            }
        }

        if (!$errorFound) {
            throw $this->elementNotFound(
                sprintf('Field "%s" has error "%s", but "%s"', $field, $errorElement->getText(), $message)
            );
        }
    }
}