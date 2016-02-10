<?php

/**
 * This class is ported back from doctrine/dbal master branch to dbal 2.5
 *
 * TODO Once Doctrine DBAL 2.6 is released, this class has to be removed!
 */

namespace Application\DoctrineExtension;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Type that maps interval string to a PHP DateInterval Object.
 */
class DateIntervalType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dateinterval';
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $fieldDeclaration['length'] = 20;
        $fieldDeclaration['fixed']  = true;

        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof \DateInterval) {
            return 'P'
                . str_pad($value->y, 4, '0', STR_PAD_LEFT) . '-'
                . $value->format('%M-%DT%H:%I:%S');
        }

        throw $this->conversionFailedInvalidType($value, $this->getName(), ['null', 'DateInterval']);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value instanceof \DateInterval) {
            return $value;
        }

        try {
            return new \DateInterval($value);
        } catch (\Exception $exception) {
            throw $this->conversionFailedFormat($value, $this->getName(), 'PY-m-dTH:i:s', $exception);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    private function conversionFailedInvalidType($value, $toType, array $possibleTypes)
    {
        $actualType = is_object($value) ? get_class($value) : gettype($value);
        if (is_scalar($value)) {
            return new \RuntimeException(sprintf(
                "Could not convert PHP value '%s' of type '%s' to type '%s'. Expected one of the following types: %s",
                $value,
                $actualType,
                $toType,
                implode(', ', $possibleTypes)
            ));
        }
        return new \RuntimeException(sprintf(
            "Could not convert PHP value of type '%s' to type '%s'. Expected one of the following types: %s",
            $actualType,
            $toType,
            implode(', ', $possibleTypes)
        ));
    }

    private function conversionFailedFormat($value, $toType, $expectedFormat, \Exception $previous = null)
    {
        $value = (strlen($value) > 32) ? substr($value, 0, 20) . '...' : $value;
        return new \RuntimeException(
            'Could not convert database value "' . $value . '" to Doctrine Type ' .
            $toType . '. Expected format: ' . $expectedFormat,
            0,
            $previous
        );
    }
}
