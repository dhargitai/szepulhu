<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Form\Type\Professional;

use Application\Form\SeoRequestHandler;
use Application\Form\Type\DateType;
use Application\Model\TimeRange;
use Doctrine\ORM\EntityRepository;
use IntlDateFormatter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\NativeRequestHandler;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ServiceSearch
 *
 * This class represents the search for service filtering.
 *
 * @package Application\Form\Type\Professional
 * @author Geza Buza <bghome@gmail.com>
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
            ->add('location', 'location', [
                'attr' => [
                    'title' => 'homepage.serviceLocation',
                ],
                'placeholder' => 'homepage.serviceLocation',
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
            ])
            ->setRequestHandler(new SeoRequestHandler(new NativeRequestHandler()));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('csrf_protection', false);
    }
}
