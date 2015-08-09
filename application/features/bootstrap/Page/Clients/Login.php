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
 * Class Login
 *
 * This is the client login page.
 *
 * @package Page\Clients
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class Login extends CustomPage
{
    protected $path = '/login';

    protected $elements = [
        'form' => ['css' => 'div.columns form']
    ];

    public function fillUsername($value)
    {
        $this->getElement('form')->fillField('username', $value);
    }

    public function fillPassword($password)
    {
        $this->getElement('form')->fillField('password', $password);
    }

    public function doLogin()
    {
        $this->getElement('form')->submit();
    }
}