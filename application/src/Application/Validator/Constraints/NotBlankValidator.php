<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class NotBlank
 *
 * This is a class level validator which ensures that the object has at least one not blank property.
 *
 * @package Application\Validator\Constraints
 * @Annotation
 * @author Geza Buza <bghome@gmail.com>
 */
class NotBlankValidator extends ConstraintValidator
{
    public function validate($object, Constraint $constraint)
    {
        if (!$constraint instanceof NotBlank) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\NotBlank');
        }

        $allBlank = true;
        foreach ($constraint->fields as $field) {
            $value = call_user_func([$object, 'get'. ucwords($field)]);
            $allBlank = $allBlank && empty($value) && $value != '0';
        }

        if ($allBlank) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
