<?php

namespace Application\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationProfessionalUserFormType extends RegistrationFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['flow_step']) {
            case 1:
                $builder
                    ->add(
                        'lastName', 'text', array('label' => 'form.last_name', 'translation_domain' => 'FOSUserBundle')
                    )
                    ->add(
                        'firstName', 'text',
                        array('label' => 'form.first_name', 'translation_domain' => 'FOSUserBundle')
                    )
                    ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
                    ->add(
                        'plainPassword', 'repeated', array(
                            'type'            => 'password',
                            'options'         => array('translation_domain' => 'FOSUserBundle'),
                            'first_options'   => array('label' => 'form.password'),
                            'second_options'  => array('label' => 'form.password_confirmation'),
                            'invalid_message' => 'fos_user.password.mismatch',
                        )
                    );
                break;
            case 2:
                $professionValues = array('Kozmetikus', 'Fodrász', 'Stylist');
                $roleValues = array('Tulajdonos', 'Alkalmazott');
                $builder
                    ->add(
                        'slug', 'text',
                        array('label' => 'form.professional_slug', 'translation_domain' => 'FOSUserBundle')
                    )
                    ->add(
                        'profession', 'choice',
                        array('choices' => $professionValues, 'placeholder' => '',
                              'label'   => 'form.professional_profession', 'choice_translation_domain' => 'FOSUserBundle')
                    )
                    ->add(
                        'role', 'choice',
                        array('choices'            => $roleValues, 'placeholder' => '',
                              'label'              => 'form.professional_role', 'choice_translation_domain' => 'FOSUserBundle')
                    );
                break;
        }
    }

    public function getName()
    {
        return 'registerProfessional';
    }


}
