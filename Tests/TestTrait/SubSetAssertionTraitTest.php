<?php declare(strict_types=1);

namespace RichCongress\TestTools\Tests\TestTrait;

use PHPUnit\Framework\ExpectationFailedException;
use RichCongress\TestTools\TestCase\TestCase;

/**
 * Class SubSetAssertionTraitTest
 *
 * @package   RichCongress\TestTools\Tests\TestTrait
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestTools\TestTrait\SubSetAssertionTrait
 * @covers \RichCongress\TestTools\TestTrait\Assertion\Parameter
 */
class SubSetAssertionTraitTest extends TestCase
{
    /**
     * @return void
     */
    public function testAssertSubSetShouldPass(): void
    {
        $tested = [1, 2, 42 => 3, 4, 'some key' => 5];
        $expected = [3, 2, 5];

        self::assertSubSet($expected, $tested);
    }

    /**
     * @return void
     */
    public function testAssertSubSetShouldFail(): void
    {
        $tested = [1, 2, 3, 4];
        $expected = [3, 2, 5];

        $this->expectException(ExpectationFailedException::class);
        self::assertSubSet($expected, $tested);
    }

    /**
     * @return void
     */
    public function testAssertSubSetShouldPassStrict(): void
    {
        $date0 = new \DateTime('@0');
        $date1 = new \DateTime('@1');
        $date2 = new \DateTime('@2');

        $tested = [$date0, $date1, $date2];
        $expected = [$date2, $date1];

        self::assertSubSet($expected, $tested, true);
    }

    /**
     * @return void
     */
    public function testAssertSubSetShouldFailStrict(): void
    {
        $tested = [new \DateTime('@0'), new \DateTime('@1'), new \DateTime('@2')];
        $expected = [new \DateTime('@2'), new \DateTime('@1')];

        $this->expectException(ExpectationFailedException::class);
        self::assertSubSet($expected, $tested, true);
    }
}
