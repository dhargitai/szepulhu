<?php

namespace Application\Model;

abstract class ValueObject
{
    protected $value = [];

    public function __get($key)
    {
        if (array_key_exists($key, $this->value)) {
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
