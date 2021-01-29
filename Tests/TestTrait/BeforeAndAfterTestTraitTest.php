<?php declare(strict_types=1);

namespace RichCongress\TestTools\Tests\TestTrait;

use RichCongress\TestTools\TestCase\TestCase;
use RichCongress\TestTools\Tests\Resources\DummyTestTrait;

/**
 * Class BeforeAndAfterTestTraitTest
 *
 * @package    RichCongress\TestTools\Tests\TestTrait
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2021 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestTools\TestTrait\BeforeAndAfterTestTrait
 */
final class BeforeAndAfterTestTraitTest extends TestCase
{
    public function testBeforeTestExecution(): void
    {
        $testCase = new DummyTestTrait();
        self::assertFalse($testCase->beforeTestExecuted);

        $testCase->setUp();
        self::assertTrue($testCase->beforeTestExecuted);
    }

    public function testAfterTestExecution(): void
    {
        $testCase = new DummyTestTrait();
        self::assertFalse($testCase->afterTestExecuted);

        $testCase->tearDown();
        self::assertTrue($testCase->afterTestExecuted);
    }
}

