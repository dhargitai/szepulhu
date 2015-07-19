<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class NotBlank
 *
 * For more info @see \Application\Validator\Constraints\NotBlankValidator.
 *
 * @package Application\Validator\Constraints
 * @Annotation
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class NotBlank extends Constraint
{
    public $message = 'validator.constraints.not_blank';

    /** @var array $fields List of object fields need to check */
    public $fields = [];

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOption()
    {
        return 'fields';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredOptions()
    {
       return ['fields'];
    }
}
