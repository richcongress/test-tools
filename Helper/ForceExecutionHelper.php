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
     * @param object|string $object
     * @param string        $method
     * @param array|mixed   $args
     *
     * @return mixed
     */
    public static function executeMethod($object, string $method, $args = [])
    {
        $reflectionMethod = static::getReflection('method', $object, $method);
        $reflectionMethod->setAccessible(true);

        $value = $reflectionMethod->invokeArgs(
            !$reflectionMethod->isStatic() ? $object : null,
            \is_array($args) ? $args : [$args]
        );

        $reflectionMethod->setAccessible(false);

        return $value;
    }

    /**
     * @param object|string $object
     * @param string        $propertyName
     * @param mixed         $value
     *
     * @return void
     */
    public static function setValue($object, string $propertyName, $value): void
    {
        $reflectionProperty = static::getReflection('property', $object, $propertyName);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue(
            !$reflectionProperty->isStatic() ? $object : null,
            $value
        );
        $reflectionProperty->setAccessible(false);
    }

    /**
     * @param object|string $object
     *
     * @return void
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
     * @param string $type
     * @param mixed  $object
     * @param string $name
     *
     * @return \ReflectionProperty|\ReflectionMethod
     */
    protected static function getReflection(string $type, $object, string $name)
    {
        static::checkObjectOrString($object);

        $reflectionClass = new \ReflectionClass($object);
        $reflection = null;

        switch ($type) {
            case 'method':
                $reflection = $reflectionClass->getMethod($name);
                break;

            case 'property':
                $reflection = $reflectionClass->getProperty($name);
                break;
        }

        if (!\is_object($object) && !$reflection->isStatic()) {
            throw new \LogicException(
                'Cannot call a non static ' . $type . ' without the instanciated object for ' . $reflectionClass->getName()
            );
        }

        return $reflection;
    }
}
