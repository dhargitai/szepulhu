<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Application\Form\DataTransformer;

/**
 * Class DummyObject
 *
 * The purpose of this class is to overcome PHPSpec's disability to handle magic method mocking.
 *
 * @package spec\Application\Form\DataTransformer
 * @author Geza Buza <bghome@gmail.com>
 */
class DummyObject
{
    private $customId;
    private $bar;

    public function __construct($customId, $bar)
    {
        $this->customId = $customId;
        $this->bar = $bar;
    }

    function getBar()
    {
        return $this->bar;
    }

    function getCustomId()
    {
        return $this->customId;
    }
}