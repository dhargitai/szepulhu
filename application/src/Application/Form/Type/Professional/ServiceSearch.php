<?php

namespace Application\Form\Type\Professional;

use Application\Form\Type\DateType;
use Application\Model\TimeRange;
use Doctrine\ORM\EntityRepository;
use IntlDateFormatter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ServiceSearch
 *
 * This class represents the search for service filtering.
 *
 * @package Application\Form\Type\Professional
 */
class ServiceSearch extends AbstractType
{
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'app_professional_search';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'attr' => [
                    'title' => 'homepage.serviceName',
                    'placeholder' => 'homepage.serviceName',
                ],
                'required' => false,
                'label' => false,
            ])
            ->add('location', 'entity', [
                'attr' => [
                    'title' => 'homepage.serviceLocation',
                ],
                'placeholder' => 'homepage.serviceLocation',
                'class' => 'AppBundle:City',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('c')
                        ->innerJoin('c.salons', 's')
                        ->orderBy('c.name', 'ASC');
                },
                'required' => false,
                'label' => false,
            ])
            ->add('date', new DateType(), [
                'attr' => [
                    'title' => 'homepage.serviceDate',
                    'placeholder' => 'homepage.serviceDate',
                    'class' => 'date',
                ],
                'widget' => 'single_text',
                'required' => false,
                'label' => false,
                'format' => IntlDateFormatter::SHORT,
            ])
            ->add('time', 'choice', [
                'attr' => [
                    'title' => 'homepage.serviceTime',
                ],
                'placeholder' => 'homepage.serviceTime',
                'choices' => (new TimeRange())->getChoices(),
                'required' => false,
                'label' => false,
            ])
            ->add('search', 'submit', [
                'label' => 'homepage.doSearch',
            ]);
    }
}
