<?php

namespace Application\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * ProfessionalUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProfessionalUserRepository extends EntityRepository
{
    public function __construct($em)
    {
        $entityName = 'Application\Entity\ProfessionalUser';
        $class = new ClassMetadata($entityName);

        parent::__construct($em, $class);
    }

    public function getFeaturedProfessionals()
    {
        return $this->createQueryBuilder('p')
            ->andWhere(':now between p.featuredFrom and p.featuredTo')
            ->setParameter('now', new \DateTime('now'))
            ->setMaxResults(5)
            ->getQuery()->getResult();
    }

    public function hasServices($professionalId)
    {
        return (boolean)$this->_em->createQueryBuilder()
            ->select('count(s.id)')
            ->from($this->_entityName, 'p')
            ->join('p.serviceGroups', 'sg')
            ->join('sg.services', 's')
            ->andWhere('p.id = :professional_id')
            ->setParameter('professional_id', $professionalId)
            ->getQuery()->getSingleScalarResult();
    }

    public function professionalOwnsPhoto($professionalSlug, $photoId)
    {
        return (boolean)$this->_em->createQueryBuilder()
            ->select('count(p.id)')
            ->from($this->_entityName, 'p')
            ->join('p.gallery', 'g')
            ->join('g.galleryHasMedias', 'gm')
            ->join('gm.media', 'm')
            ->andWhere('p.slug = :professionalSlug')
            ->andWhere('m.id = :photoId')
            ->setParameter('professionalSlug', $professionalSlug)
            ->setParameter('photoId', $photoId)
            ->getQuery()->getSingleScalarResult();
    }
}
