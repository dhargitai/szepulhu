<?php

namespace Application\Interactor;

use Application\Model\ValueObject;

class FeaturedProfessionalsResponse extends ValueObject
{
    public function getSlug()
    {
        return $this->value['slug'];
    }

    public function getProfilePicture()
    {
        return $this->value['profilePicture'];
    }

    public function getLastName()
    {
        return $this->value['lastName'];
    }

    public function getFirstName()
    {
        return $this->value['firstName'];
    }

    public function getProfession()
    {
        return $this->value['profession'];
    }
}
