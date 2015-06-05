<?php

namespace Application\Model;

class ValueObject
{
    protected $value = [];

    public function __construct(array $attributes = array())
    {
        foreach ($attributes as $name => $value) {
            $this->value[$name] = $value;
        }
    }

    public function __get($key)
    {
        if (isset($this->value[$key])) {
            return $this->value[$key];
        }

        throw new \DomainException(sprintf('The property "%s" does not exist in object %s.', $key, get_class($this)));
    }

    public function __isset($key)
    {
        return isset($this->value[$key]);
    }

    public function asArray()
    {
        return $this->value;
    }
}
