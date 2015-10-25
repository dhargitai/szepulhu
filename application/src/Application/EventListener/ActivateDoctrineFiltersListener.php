<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class ActivateDoctrineFiltersListener
 *
 * This class enables Doctrine filters on a global basis. Any filter can be turned on later by the EntityManager.
 *
 * @package Application\EventListener
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class ActivateDoctrineFiltersListener
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /**
     * Constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Handle request before the event is dispatched to the controller
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->entityManager
            ->getFilters()
            ->enable('active_user');
    }
}