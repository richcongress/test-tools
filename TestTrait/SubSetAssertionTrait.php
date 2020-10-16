<?php declare(strict_types=1);

namespace RichCongress\TestTools\TestTrait;

/**
 * Trait SubSetAssertionTrait
 *
 * @package   RichCongress\TestTools\TestTrait
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 */
trait SubSetAssertionTrait
{
    /**
     * @param array $expected
     * @param array $tested
     *
     * @return void
     */
    protected static function assertSubSet(array $expected, array $tested): void
    {
        foreach ($expected as $expectedValue) {
            static::assertContains($expectedValue, $tested, '', false);
        }
    }
}
