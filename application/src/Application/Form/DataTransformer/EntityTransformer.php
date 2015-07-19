<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class EntityTransformer
 *
 * This class converts an entity object to a single ID value which can be used in HTML form and vice versa.
 * See Symfony's documentation about how to add data transformers to form fields.
 *
 * @package Application\Form\Type\Professional
 * @author Geza Buza <bghome@gmail.com>
 */
 class EntityTransformer implements DataTransformerInterface
 {
    private $entityManager;
    private $entityClass;
    private $idColumnName;

    public function __construct(EntityManager $entityManager, $entityClass, $idColumnName = null)
    {
       $this->entityManager = $entityManager;
       $this->entityClass = $entityClass;
       $this->idColumnName = is_null($idColumnName) ? $this->getIdFieldFromMetadata(): $idColumnName;
    }

    /**
     * Transforms an entity object to a string
     *
     * @param  \stdClass|null $entityObject
     * @return string
     */
    public function transform($entityObject)
    {
        if (null === $entityObject) {
            return '';
        }

        $getId = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $this->idColumnName)));
        return (string)$entityObject->$getId();
    }

    /**
     * Transforms a string to an entity object
     *
     * @param  string $id
     * @return \stdClass|null
     * @throws TransformationFailedException if object is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $entityObject = $this->entityManager
            ->getRepository($this->entityClass)
            ->findOneBy([$this->idColumnName => $id]);

        if ($entityObject === null) {
            throw new TransformationFailedException(sprintf(
                'The entity %s with %s value "%s" does not exist!',
                $this->entityClass,
                $this->idColumnName,
                $id
            ));
        }

        return $entityObject;
    }

    private function getIdFieldFromMetadata()
    {
        $classMetadata = $this->entityManager->getClassMetadata($this->entityClass);
        $idFieldNames = $classMetadata->getIdentifierFieldNames();
        if (count($idFieldNames) === 1) {
            return current($idFieldNames);
        }
        throw new TransformationFailedException(sprintf(
            'Only single entity ID is supported, but the entity %s has %d number of primary keys!',
            $this->entityClass,
            count($idFieldNames)
        ));
    }
 }
