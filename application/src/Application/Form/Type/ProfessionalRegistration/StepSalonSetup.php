<?php
/**
 *
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.02.20.
 * @package   SzepulHu_Form
 */

namespace Application\Form\Type\ProfessionalRegistration;

use Application\Entity\ProfessionalUser;
use Application\Form\Type\SalonFormType;
use Application\Model\Professional;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StepSalonSetup extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $salonRoles = ProfessionalUser::getSalonRoles();
        $phoneChoices = array(
            Professional::PREFERRED_PHONE_SALON => 'form.salon.phone',
            Professional::PREFERRED_PHONE_PERSONAL => 'form.professional.phone',
        );
        $name = $options['lastName'] . " " . $options['firstName'];
        $builder
            ->add(
                'role', 'choice',
                array(
                    'choices'            => $salonRoles,
                    'translation_domain' => 'Application',
                )
            )
            ->add(
                'name', 'text', array(
                    'label'              => 'form.name',
                    'translation_domain' => 'Application',
                    'data'               => $name,
                )
            )
            ->add('salon', new SalonFormType())
            ->add('phone', 'text', array('label' => 'form.professional.phone', 'translation_domain' => 'Application'))
            ->add(
                'preferredPhoneOnProfile', 'choice',
                array(
                    'choices'            => $phoneChoices,
                    'expanded' => true,
                    'multiple' => false,
                    'translation_domain' => 'Application',
                )
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'firstName' => '',
                'lastName'  => '',
            )
        );
    }

    public function getName()
    {
        return 'registerProfessionalStepSalonSetup';
    }
}
