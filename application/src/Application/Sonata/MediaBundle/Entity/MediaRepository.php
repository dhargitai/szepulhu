<?php

/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\MediaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class MediaRepository
 *
 * @package Application\Sonata\MediaBundle\Entity
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class MediaRepository extends EntityRepository
{
    public function __construct($em, ClassMetadata $class = null)
    {
        if (empty($class)) {
            $entityName = 'Application\Sonata\MediaBundle\Entity\Media';
            $class = new ClassMetadata($entityName);
        }

        parent::__construct($em, $class);
    }
}
