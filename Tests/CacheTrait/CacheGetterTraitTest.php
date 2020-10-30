<?php declare(strict_types=1);

namespace RichCongress\TestTools\Tests\CacheTrait;

use PHPUnit\Framework\TestCase;
use RichCongress\TestTools\CacheTrait\CachedGetterTrait;
use RichCongress\TestTools\Tests\Resources\Event\DummyEvent;

/**
 * Class CacheGetterTraitTest
 *
 * @package    RichCongress\TestTools\Tests\CacheTrait
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestTools\CacheTrait\CachedGetterTrait
 * @method DummyEvent getEvent()
 * @method bool getLoop()
 * @method static DummyEvent getStaticEvent()
 */
final class CacheGetterTraitTest extends TestCase
{
    use CachedGetterTrait;

    public function testGetObjectTwiceWithOnlyOneInstanciation(): void
    {
        $event = $this->getEvent();
        self::assertInstanceOf(DummyEvent::class, $event);

        $event2 = $this->getEvent();
        self::assertSame($event, $event2);
    }

    public function testGetStaticObjectTwiceWithOnlyOneInstanciation(): void
    {
        $event = self::getStaticEvent();
        self::assertInstanceOf(DummyEvent::class, $event);

        $event2 = self::getStaticEvent();
        self::assertSame($event, $event2);
    }

    public function testCallNotGetter(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $this->testNotExistingMethod();
    }

    public function testCallNoCreate(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $this->getNotExistingProperty();
    }


    public function testCallLoop(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $this->getLoop();
    }

    private function createEvent(): DummyEvent
    {
        return new DummyEvent();
    }

    private static function createStaticEvent(): DummyEvent
    {
        return new DummyEvent();
    }

    private function createLoop(): bool
    {
        return $this->getLoop();
    }
}
