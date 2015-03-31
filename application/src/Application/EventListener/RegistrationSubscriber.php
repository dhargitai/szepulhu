<?php
/**
 * Registration listener
 *
 * @author Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.02.19.
 * @package SzepulHu_EventListener
 */

namespace Application\EventListener;

use Application\Entity\ClientUser;
use Application\Entity\ProfessionalUser;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RegistrationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSucces'
        );
    }

    public function onRegistrationSucces(FormEvent $event)
    {
        $viewData = $event->getForm()->getViewData();
        if ($viewData instanceof ProfessionalUser) {
            echo 'ez profi';die;
        }
    }
}
