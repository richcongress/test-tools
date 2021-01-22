<?php declare(strict_types=1);

namespace RichCongress\TestTools\Helper;

/**
 * Class ForceExecutionHelper
 *
 * @package   RichCongress\TestTools\Helper
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class ForceExecutionHelper
{
    /**
     * ForceExecutionHelper constructor.
     *
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Block the instanciation
    }

    /**
     * @param object|class-string<object> $object
     * @param array|mixed   $args
     *
     * @return mixed
     */
    public static function executeMethod($object, string $method, ...$args)
    {
        $reflectionMethod = static::getReflectionMethod($object, $method);
        $reflectionMethod->setAccessible(true);
        $value = $reflectionMethod->isStatic()
            ? $reflectionMethod->invoke(null, ...$args)
            : $reflectionMethod->invoke($object, ...$args);

        $reflectionMethod->setAccessible(false);

        return $value;
    }

    /**
     * @param object|class-string<object> $object
     * @param mixed $value
     */
    public static function setValue($object, string $propertyName, $value): void
    {
        $reflectionProperty = static::getReflectionProperty($object, $propertyName);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->isStatic()
            ? $reflectionProperty->setValue(null, $value)
            : $reflectionProperty->setValue($object, $value);

        $reflectionProperty->setAccessible(false);
    }

    /**
     * @param object|class-string<object>|mixed $object
     */
    protected static function checkObjectOrString($object): void
    {
        if (is_object($object) || is_string($object)) {
            return;
        }

        throw new \InvalidArgumentException(
            sprintf(
                'The first argument must be an object or a class name, %s given.',
                \gettype($object)
            )
        );
    }

    /**
     * @param object|class-string<object> $object
     */
    protected static function getReflectionProperty($object, string $name): \ReflectionProperty
    {
        static::checkObjectOrString($object);

        $reflectionClass = new \ReflectionClass($object);
        $reflection = $reflectionClass->getProperty($name);

        if (!\is_object($object) && !$reflection->isStatic()) {
            throw new \LogicException(
                'Cannot call a non static property without the instanciated object for ' . $reflectionClass->getName()
            );
        }

        return $reflection;
    }

    /**
     * @param object|class-string<object> $object
     */
    protected static function getReflectionMethod($object, string $name): \ReflectionMethod
    {
        static::checkObjectOrString($object);

        $reflectionClass = new \ReflectionClass($object);
        $reflection = $reflectionClass->getMethod($name);

        if (!\is_object($object) && !$reflection->isStatic()) {
            throw new \LogicException(
                'Cannot call a non static method without the instanciated object for ' . $reflectionClass->getName()
            );
        }

        return $reflection;
    }
}
