<?php

namespace Application\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as FOSRegistrationController;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends FOSRegistrationController
{
    public function registerProfessionalAction(Request $request)
    {
        return $this->container
            ->get('pugx_multi_user.registration_manager')
            ->register('Application\Entity\ProfessionalUser');
    }

    public function registerClientAction(Request $request)
    {
        return $this->container
            ->get('pugx_multi_user.registration_manager')
            ->register('Application\Entity\ClientUser');
    }
}
