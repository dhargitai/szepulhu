<?php
/**
 *
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.02.24.
 * @package   SzepulHu_Form_Type
 */

namespace Application\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SalonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'form.salon.name', 'translation_domain' => 'Application'))
            ->add('postCode', 'text', array('label' => 'form.salon.postCode', 'translation_domain' => 'Application'))
            ->add('city', 'text', array('label' => 'form.salon.city', 'translation_domain' => 'Application'))
            ->add('address', 'text', array('label' => 'form.salon.address', 'translation_domain' => 'Application'))
            ->add('addressAdditional', 'text', array('label' => 'form.salon.addressAdditional', 'translation_domain' => 'Application'))
            ->add('phone', 'text', array('label' => 'form.salon.phone', 'translation_domain' => 'Application'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Application\Entity\Professional\Salon',
            )
        );
    }

    public function getName()
    {
        return 'salon';
    }
}
