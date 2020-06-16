<?php declare(strict_types=1);

namespace RichCongress\UnitTestBundle\Tests\TextUi;

use PHPUnit\Framework\TestCase;
use RichCongress\UnitTestBundle\TextUi\Timer;

/**
 * Class TimerTest
 *
 * @package   RichCongress\UnitTestBundle\Tests\TextUi
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2019 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\UnitTestBundle\TextUi\Timer
 */
class TimerTest extends TestCase
{
    /**
     * @return void
     */
    public function testStopWithoutStart(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('The timer is not started');

        Timer::stop();
    }

    /**
     * @return void
     */
    public function testStop(): void
    {
        Timer::start();
        sleep(1);
        $time = Timer::stop();

        self::assertGreaterThan(0, $time);
    }

    /**
     * @return void
     */
    public function testStopString(): void
    {
        Timer::start();
        $time = Timer::stopToString();

        self::assertSame('0ms', $time);
    }

    /**
     * @return void
     */
    public function testStopStringMoreThanOneSecond(): void
    {
        Timer::start();
        sleep(1);
        $time = Timer::stopToString();

        self::assertSame('1.00s', $time);
    }
}
