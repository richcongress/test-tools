<?php declare(strict_types=1);

namespace RichCongress\TestTools\CacheTrait;

/**
 * Trait CachedGetterTrait
 *
 * @package    RichCongress\TestTools\CacheTrait
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
trait CachedGetterTrait
{
    /** @var array<string, object> */
    private $cacheGetters = [];

    /** @var array<string, object> */
    private static $staticCacheGetters = [];

    /** @var object|null */
    private static $previousCall;

    public function __call(string $method, array $arguments)
    {
        return self::getObject(
            $this->cacheGetters,
            $method,
            function (string $factory) use ($arguments) {
                return $this->$factory(...$arguments);
            }
        );
    }

    public static function __callStatic(string $method, array $arguments)
    {
        return self::getObject(
            self::$staticCacheGetters,
            $method,
            static function (string $factory) use ($arguments) {
                return static::$factory(...$arguments);
            }
        );
    }

    private static function getObject(array &$cache, string $method, callable $callback)
    {
        if (0 !== strpos($method, 'get')) {
            throw new \BadMethodCallException('Unknown method ' . $method);
        }

        if (!array_key_exists($method, $cache)) {
            $realMethod = str_replace('get', 'create', $method);

            if ($realMethod === self::$previousCall) {
                throw new \BadMethodCallException('Unknown method ' . $method);
            }

            self::$previousCall = $realMethod;
            $service = $callback($realMethod);
            $cache[$method] = $service;
        }

        return $cache[$method];
    }
}
