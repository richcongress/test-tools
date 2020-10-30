<?php declare(strict_types=1);

namespace RichCongress\TestTools\TestTrait;

use RichCongress\TestTools\Accessor\ForcePropertyAccessor;
use RichCongress\TestTools\CacheTrait\CachedGetterTrait;
use RichCongress\TestTools\TestTrait\Assertion\Parameter;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Trait MatchAssertionTrait
 *
 * @package   RichCongress\TestTools\TestTrait
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @method static PropertyAccessorInterface getPropertyAccessor()
 */
trait MatchAssertionTrait
{
    use CachedGetterTrait;

    /**
     * @param array        $expected
     * @param array|object $tested
     *
     * @return void
     */
    protected static function assertMatch(array $expected, $tested): void
    {
        // The array key presences are tested in the first place
        if (is_array($tested)) {
            foreach (array_keys($expected) as $expectedKey) {
                self::assertArrayHasKey($expectedKey, $tested);
            }
        }

        // The content of each key is then tested
        foreach ($expected as $expectedKey => $expectedMatch) {
            $testedValue = static::getMatchValue($tested, $expectedKey);

            if ($expectedMatch instanceof Parameter) {
                static::assertMatchParameter($expectedMatch, $testedValue);
            } else if (is_array($expectedMatch) || is_object($expectedMatch)) {
                static::assertMatch($expectedMatch, $testedValue);
            } else if ($expectedMatch !== null) {
                static::assertEquals($expectedMatch, $testedValue);
            }
        }
    }

    /**
     * @param array|object $object
     * @param int|string   $expectedKey
     */
    private static function getMatchValue($object, $expectedKey)
    {
        if (is_array($object)) {
            return $object[$expectedKey];
        }

        return self::getPropertyAccessor()->getValue($object, $expectedKey);
    }

    /**
     * @param Parameter $parameter
     * @param mixed     $testedValue
     *
     * @return void
     */
    private static function assertMatchParameter(Parameter $parameter, $testedValue): void
    {
        // Type test
        switch ($parameter->type) {
            case 'string':
                self::assertIsString($testedValue);
                break;

            case 'integer':
                self::assertIsInt($testedValue);
                break;

            case 'float':
                self::assertIsFloat($testedValue);
                break;

            case 'array':
                self::assertIsArray($testedValue);
                break;

            case 'boolean':
                self::assertIsBool($testedValue);
                break;
        }

        // Regex test
        if ($parameter->regex !== null) {
            self::assertRegExp($parameter->regex, $testedValue);
        }

        // Choice test
        if ($parameter->choice !== null) {
            self::assertContainsEquals($testedValue, $parameter->choice);
        }

        if ($parameter->class !== null) {
            self::assertInstanceOf($parameter->class, $testedValue);
        }
    }

    private static function createPropertyAccessor(): PropertyAccessorInterface
    {
        return new ForcePropertyAccessor();
    }
}
