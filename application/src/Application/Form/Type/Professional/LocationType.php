<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Form\Type\Professional;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManager;
use Application\Form\DataTransformer\EntityTransformer;

/**
 * Class LocationType
 *
 * This form element represents a list of cities.
 * For more info @see \Application\Entity|City class.
 *
 * @package Application\Form\Type\Professional
 * @author Geza Buza <bghome@gmail.com>
 */
class LocationType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManager $manager)
    {
        $this->entityManager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'location';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(
            [
                'class' => 'AppBundle:City',
                'choices' => $this->getChoices(),
                'invalid_message' => 'app.city.invalid_location',
            ]
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new EntityTransformer($this->entityManager, $options['class'], 'slug'));
    }

    private function getChoices()
    {
        $query = $this->entityManager->createQueryBuilder('city')
                ->select(['city.slug', 'city.name'])
                ->from('AppBundle:City', 'city')
                ->innerJoin('city.professionals', 'professionals')
                ->orderBy('city.name', 'ASC')
                ->getQuery();

        $choices = [];
        foreach ($query->getArrayResult() as $value) {
            $choices[$value['slug']] = $value['name'];
        }
        return $choices;
    }
}
