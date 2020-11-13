<?php declare(strict_types=1);

namespace RichCongress\TestTools\Accessor;

use Symfony\Component\PropertyAccess\Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyAccess\PropertyPathInterface;

/**
 * Class ForcePropertyAccessor
 *
 * @package    RichCongress\TestTools\Accessor
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
final class ForcePropertyAccessor implements PropertyAccessorInterface
{
    /** @var PropertyAccessorInterface */
    private $innerPropertyAccessor;

    public function __construct(PropertyAccessorInterface $propertyAccessor = null)
    {
        if ($propertyAccessor === null) {
            $this->innerPropertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
                ->enableMagicCall()
                ->getPropertyAccessor();
        } else {
            $this->innerPropertyAccessor = $propertyAccessor;
        }
    }

    /**
     * @param array|object|mixed                  $objectOrArray
     * @param string|PropertyPathInterface<mixed> $propertyPath
     * @param mixed                               $value
     */
    public function setValue(&$objectOrArray, $propertyPath, $value): void
    {
        try {
            $this->innerPropertyAccessor->setValue($objectOrArray, $propertyPath, $value);
        } catch (Exception\NoSuchPropertyException $exception) {
            $propertyReflection = $this->getPropertyReflection($objectOrArray, $propertyPath);

            if ($propertyReflection === null) {
                throw $exception;
            }

            $propertyReflection->setAccessible(true);
            $propertyReflection->setValue($objectOrArray, $value);
            $propertyReflection->setAccessible(false);
        }
    }

    /**
     * @param array|object|mixed                  $objectOrArray
     * @param string|PropertyPathInterface<mixed> $propertyPath
     *
     * @return mixed|null
     */
    public function getValue($objectOrArray, $propertyPath)
    {
        try {
            return $this->innerPropertyAccessor->getValue($objectOrArray, $propertyPath);
        } catch (Exception\NoSuchPropertyException $exception) {
            $propertyReflection = $this->getPropertyReflection($objectOrArray, $propertyPath);

            if ($propertyReflection === null) {
                throw $exception;
            }

            $propertyReflection->setAccessible(true);
            $value = $propertyReflection->getValue($objectOrArray);
            $propertyReflection->setAccessible(false);

            return $value;
        }
    }

    /**
     * @param array|object|mixed                  $objectOrArray
     * @param string|PropertyPathInterface<mixed> $propertyPath
     */
    public function isWritable($objectOrArray, $propertyPath): bool
    {
        return $this->innerPropertyAccessor->isWritable($objectOrArray, $propertyPath)
            || $this->getPropertyReflection($objectOrArray, $propertyPath) !== null;
    }

    /**
     * @param array|object|mixed                  $objectOrArray
     * @param string|PropertyPathInterface<mixed> $propertyPath
     */
    public function isReadable($objectOrArray, $propertyPath): bool
    {
        return $this->innerPropertyAccessor->isReadable($objectOrArray, $propertyPath)
            || $this->getPropertyReflection($objectOrArray, $propertyPath) !== null;
    }

    /**
     * @param array|object|mixed                  $objectOrArray
     * @param string|PropertyPathInterface<mixed> $propertyPath
     */
    private function getPropertyReflection($objectOrArray, $propertyPath): ?\ReflectionProperty
    {
        if (!is_object($objectOrArray)) {
            return null;
        }

        $reflectionClass = new \ReflectionClass($objectOrArray);

        while ($reflectionClass instanceof \ReflectionClass) {
            if ($reflectionClass->hasProperty((string)$propertyPath)) {
                return $reflectionClass->getProperty((string)$propertyPath);
            }

            $reflectionClass = $reflectionClass->getParentClass();
        }

        return null;
    }
}
