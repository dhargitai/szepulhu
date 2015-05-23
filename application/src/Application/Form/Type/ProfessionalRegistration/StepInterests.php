<?php
/**
 *
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.02.20.
 * @package   SzepulHu_Form
 */

namespace Application\Form\Type\ProfessionalRegistration;

use Application\Model\Professional;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class StepInterests extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $interests = array(
            Professional::INTEREST_FREE_APPOINTMENT_SCHEDULING
            => Professional::INTEREST_FREE_APPOINTMENT_SCHEDULING,
            Professional::INTEREST_FREE_CLIENT_TRACKING
            => Professional::INTEREST_FREE_CLIENT_TRACKING,
            Professional::INTEREST_FREE_WEBSITE_AND_ONLINE_MARKETING
            => Professional::INTEREST_FREE_WEBSITE_AND_ONLINE_MARKETING,
            Professional::INTEREST_GROW_AND_SIMPLIFY_BUSINESS
            => Professional::INTEREST_GROW_AND_SIMPLIFY_BUSINESS,
            Professional::INTEREST_NOT_SURE
            => Professional::INTEREST_NOT_SURE,
        );
        $builder
            ->add(
                'interests',
                'choice',
                array(
                    'label'                     => 'form.professional.interests',
                    'choices'                   => $interests,
                    'choice_translation_domain' => 'Application',
                    'multiple'                  => true,
                    'expanded'                  => true,
                )
            );
    }

    public function getName()
    {
        return 'registerProfessionalStepInterests';
    }
}
