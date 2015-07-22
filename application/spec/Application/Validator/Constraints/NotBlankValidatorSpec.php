<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Application\Validator\Constraints;

use Application\Validator\Constraints\NotBlank;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilder;

require_once 'DummyObject.php';

/**
 * Class NotBlankValidatorSpec
 *
 * @package spec\Application\Validator\Constraints
 * @author Geza Buza <bghome@gmail.com>
 */
class NotBlankValidatorSpec extends ObjectBehavior
{
    function let(ExecutionContextInterface $context, ConstraintViolationBuilder $builder)
    {
        $this->initContextDouble($context, $builder);
        $this->initialize($context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Application\Validator\Constraints\NotBlankValidator');
    }

    function it_throws_exception_for_invalid_constraints(Blank $invalidConstraint, NotBlank $validConstraint)
    {
        $object = new \stdClass();
        $this->shouldThrow('Symfony\Component\Validator\Exception\UnexpectedTypeException')
            ->duringValidate($object, $invalidConstraint);

        $this->validate($object, $validConstraint);
    }

    function it_does_not_raise_error_when_object_is_valid(
        ExecutionContextInterface $context, ConstraintViolationBuilder $builder
    ) {
        $constraint = new NotBlank([
            'fields' => ['a', 'b']
        ]);
        $object = new DummyObject(['a'=>0, 'b'=>2]);

        $context->buildViolation(Argument::type('string'))->shouldNotBeCalled()->willReturn($builder);

        $this->validate($object, $constraint);
    }

    function it_raises_an_error_when_object_is_invalid(
        ExecutionContextInterface $context, ConstraintViolationBuilder $builder
    ) {
        $constraint = new NotBlank([
            'fields' => ['a', 'b']
        ]);
        $object = new DummyObject(['a'=>null, 'b'=>null]);

        $context->buildViolation($constraint->message)->shouldBeCalled()->willReturn($builder);

        $this->validate($object, $constraint);
    }

    private function initContextDouble(ExecutionContextInterface $context, ConstraintViolationBuilder $builder)
    {
        $builder->addViolation()->willReturn(null);
        $context->buildViolation(Argument::any())->willReturn($builder->getWrappedObject());
    }
}
