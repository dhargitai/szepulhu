<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Interactor;
use Application\Entity\ProfessionalUserRepository;
use Application\Model\Professional\ServiceSearchParameters;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ProfessionalSearchInteractor
 *
 * This class represents all the search actions that a user can use to find professionals.
 *
 * @package Application\Interactor
 * @author Geza Buza <bghome@gmail.com>
 */
class ProfessionalSearchInteractor
{
    private $repository;

    public function __construct(ProfessionalUserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Build the search query based on the given search parameters
     *
     * @param ServiceSearchParameters $parameters
     * @return Query
     */
    public function createSearchQuery(ServiceSearchParameters $parameters)
    {
        $queryBuilder = $this->repository->createQueryBuilder('professionals');
        $values = [];

        if ($name = $parameters->getName()) {
            $queryBuilder->leftJoin('professionals.serviceGroups', 'service_groups')
                ->leftJoin('service_groups.services', 'services')
                ->andWhere('services.name LIKE ?1');
            $values[1] = '%' . addcslashes($name, '%_?') . '%';
        }
        if ($location = $parameters->getLocation()) {
            $queryBuilder->andWhere('professionals.city = ?2');
            $values[2] = $location;
        }

        // TODO Filter for date and time (waiting for reservation to be finished)

        $queryBuilder->setParameters($values);

        return $queryBuilder->getQuery();
    }

    private function joinSalon(QueryBuilder $queryBuilder)
    {
        if (!in_array('salon', $queryBuilder->getAllAliases())) {
            $queryBuilder->leftJoin('professionals.salon', 'salon');
        }
        return $queryBuilder;
    }
}