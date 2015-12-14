<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\DoctrineExtension\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * Class ActiveUserFilter
 *
 * Apply filter conditions to all FOS\UserBundle\Model\User entities in order to get back only users who are allowed
 * to use the website.
 *
 * @package Application\DoctrineExtension\Filter
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class ActiveUserFilter extends SQLFilter
{
    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $targetEntity
     * @param string $targetTableAlias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$targetEntity->getReflectionClass()->isSubclassOf('FOS\UserBundle\Model\User')) {
            return '';
        }

        return sprintf('%1$s.enabled = true AND %1$s.expired = false', $targetTableAlias);
    }
}