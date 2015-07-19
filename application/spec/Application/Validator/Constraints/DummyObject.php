<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Application\Validator\Constraints;


/**
 * Class DummyObject
 *
 * The purpose of this class is to overcome PHPSpec's disability to handle magic method mocking.
 *
 * @internal This class should be used in tests only!
 * @package spec\Application\Validator\Constraints
 * @author Geza Buza <bghome@gmail.com>
 */
class DummyObject
{
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function getA()
    {
        return $this->get('a');
    }

    public function getB()
    {
        return $this->get('b');
    }

    private function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}