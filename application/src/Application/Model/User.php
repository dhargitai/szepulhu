<?php

namespace Application\Model;

use FOS\UserBundle\Model\UserInterface as BaseUserInterface;

interface User extends BaseUserInterface
{
    const GENDER_FEMALE  = 'f';
    const GENDER_MALE    = 'm';
    const GENDER_UNKNOWN = 'u';
}
