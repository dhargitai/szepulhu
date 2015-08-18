<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Page\Clients;
use Page\CustomPage;


/**
 * Class Registration
 *
 * This is the client registration page.
 *
 * @package Page\Clients
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class Registration extends CustomPage
{
    protected $path = '/registration/';

    /**
     * Fill in the element given by the field parameter
     *
     * @param string $field Element locator
     * @param string $value Element value
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillRegistrationFormField($field, $value)
    {
        $this->getRegistrationForm()->fillField($field, $value);
    }

    /**
     * Send the registration form
     */
    public function submitRegistration()
    {
        $this->getRegistrationForm()->submit();
    }

    /**
     * Check whether the form input has the given error
     *
     * @param string $field
     * @param string $message
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function ensureFieldHasError($field, $message)
    {
        $this->getElement('Clients\Registration form')->ensureFieldHasError($field, $message);
    }

    /**
     * @return \Page\Element\Clients\RegistrationForm
     */
    protected function getRegistrationForm()
    {
        return $this->getElement('Clients\Registration form');
    }
}