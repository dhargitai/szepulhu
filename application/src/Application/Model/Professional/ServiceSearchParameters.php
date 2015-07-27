<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Model\Professional;

use Application\Entity\City;
use Iterator;
use Symfony\Component\Validator\Constraints as Assert;
use Application\Validator\Constraints as AppAssert;

/**
 * Class ServiceSearchParameters
 *
 * This data transfer object holds public, searchable parameters of a service.
 *
 * @package Application\Model\Professional
 * @author Geza Buza <bghome@gmail.com>
 *
 * @AppAssert\NotBlank(fields={"name", "location", "date", "time"})
 */
class ServiceSearchParameters implements Iterator
{
    /**
     * @Assert\Type(type="string")
     */
    protected $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="Application\Entity\City")
     */
    protected $location;

    /**
     * @Assert\Date()
     */
    protected $date;

    /**
     * @Assert\Choice(callback={"TimeRange", "getChoices"})
     */
    protected $time;

    private $traversableProperties = ['name', 'location', 'date', 'time'];

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        $property = current($this->traversableProperties);
        $value = $this->$property;
        if ($value instanceof City) {
            return $value->getSlug();
        }
        return $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        next($this->traversableProperties);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return current($this->traversableProperties);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return current($this->traversableProperties) !== false;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        reset($this->traversableProperties);
    }
}
