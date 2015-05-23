<?php
/**
 *
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.02.20.
 * @package   SzepulHu_Form
 */

namespace Application\Form\Type\ProfessionalRegistration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class StepBasicData extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'lastName',
                'text',
                array('label' => 'form.professional.last_name', 'translation_domain' => 'Application')
            )
            ->add(
                'firstName',
                'text',
                array('label' => 'form.professional.first_name', 'translation_domain' => 'Application')
            )
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add(
                'plainPassword',
                'repeated',
                array(
                    'type'            => 'password',
                    'options'         => array('translation_domain' => 'FOSUserBundle'),
                    'first_options'   => array('label' => 'form.password'),
                    'second_options'  => array('label' => 'form.password_confirmation'),
                    'invalid_message' => 'fos_user.password.mismatch',
                )
            );
    }

    public function getName()
    {
        return 'registerProfessionalStepBasicData';
    }
}
