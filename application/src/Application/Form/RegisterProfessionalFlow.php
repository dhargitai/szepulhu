<?php
/**
 * Flow for register a professional
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.02.20.
 * @package   SzepulHu_Form
 */

namespace Application\Form;

use Application\Form\Type\ProfessionalRegistration\StepBasicData;
use Application\Form\Type\ProfessionalRegistration\StepInterests;
use Application\Form\Type\ProfessionalRegistration\StepSalonSetup;
use Craue\FormFlowBundle\Form\FormFlow;
use Symfony\Component\Form\FormTypeInterface;

class RegisterProfessionalFlow extends FormFlow
{
    public function getName()
    {
        return 'registerProfessionalFlow';
    }

    protected function loadStepsConfig()
    {
        return array(
            array(
                'label' => 'Alapadatok',
                'type'  => new StepBasicData(),
            ),
            array(
                'label' => 'Érdeklődési területek',
                'type'  => new StepInterests(),
            ),
            array(
                'label' => 'Szalonod beállítása',
                'type'  => new StepSalonSetup(),
            ),
            array(
                'label' => 'Ellenőrzés',
            ),
        );
    }

    public function getFormOptions($step, array $options = array())
    {
        $options = parent::getFormOptions($step, $options);
        if ($step === 3) {
            $options['firstName'] = $this->getFormData()->getFirstName();
            $options['lastName'] = $this->getFormData()->getLastName();
        }
        return $options;
    }
}
