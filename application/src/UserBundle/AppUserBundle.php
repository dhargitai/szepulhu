<?php

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
