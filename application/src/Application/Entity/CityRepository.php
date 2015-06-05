<?php

namespace Application\Entity;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr\Join;

/**
 * CityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CityRepository extends \Doctrine\ORM\EntityRepository
{
    public function __construct($em)
    {
        $entityName = 'Application\Entity\City';
        $class = new ClassMetadata($entityName);

        parent::__construct($em, $class);
    }

    public function getCapital()
    {
        return $this->createQueryBuilder('ci')
            ->andWhere('ci.isBigCity = 1 and ci.isCapital = 1')
            ->getQuery()->getSingleResult();
    }

    public function getBigCitiesWithActiveFeaturedProfessionals()
    {
        return $this->createQueryBuilder('ci')
            ->join('ci.professionals', 'p', Join::WITH, ':now between p.featuredFrom and p.featuredTo')
            ->andWhere('ci.isBigCity = 1 or ci.isCapital = 1')
            ->setParameter('now', new \DateTime('now'))
            ->distinct()
            ->orderBy('ci.isCapital', 'desc')
            ->addOrderBy('ci.name')
            ->getQuery()->getResult();
    }
}
