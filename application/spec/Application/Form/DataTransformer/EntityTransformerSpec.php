<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Application\Form\DataTransformer;

use Application\Form\DataTransformer\EntityTransformer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

require_once 'DummyObject.php';

/**
 * Class EntityTransformerSpec
 *
 * @package spec\Application\Form\DataTransformer
 * @author Geza Buza <bghome@gmail.com>
 */
class EntityTransformerSpec extends ObjectBehavior
{
    private $entityClass = 'FooEntity';
    private $idColumnName = 'bar';

    function let(EntityManager $entityManager, EntityRepository $entityRepository)
    {
        $this->initEntityManagerDouble($entityManager, $entityRepository);
        $this->initEntityRepository($entityRepository);
        $this->beConstructedThrough([$this, 'createObject'], [$entityManager]);
    }

    /**
     * @param EntityManager $entityManager
     * @return EntityTransformer
     */
    function createObject(EntityManager $entityManager)
    {
        return new EntityTransformer($entityManager, $this->entityClass, $this->idColumnName);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Form\DataTransformer\EntityTransformer');
    }

    function it_transforms_an_entity_to_string_id()
    {
        $entity = new DummyObject(1234, 5678);

        $this->transform($entity)->shouldReturn('5678');
    }

    function it_transforms_string_id_to_entity(EntityRepository $entityRepository)
    {
        $entity = new DummyObject(1234, 5678);
        $entityRepository->findOneBy([$this->idColumnName => '5678'])->willReturn($entity);

        $this->reverseTransform('5678')->shouldReturn($entity);
    }

    function it_finds_the_id_column_name_automatically_when_not_set(
        EntityManager $entityManager, ClassMetadataInfo $metadata
    )
    {
        $this->idColumnName = null;

        $entityManager->getClassMetadata($this->entityClass)->willReturn($metadata);
        $metadata->getIdentifierFieldNames()->willReturn(['custom_id']);

        $entity = new DummyObject('1234', '5678');

        $this->transform($entity)->shouldReturn('1234');

        $this->shouldHaveType('Application\Form\DataTransformer\EntityTransformer');
    }

    private function initEntityManagerDouble(EntityManager $entityManager, EntityRepository $entityRepository)
    {
        $entityManager->getRepository($this->entityClass)->willReturn($entityRepository);
    }

    private function initEntityRepository(EntityRepository $entityRepository)
    {
        $entityRepository->findOneBy(Argument::any())->willReturn(new \stdClass());
    }
}
