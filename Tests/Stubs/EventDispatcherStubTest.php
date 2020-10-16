<?php declare(strict_types=1);

namespace RichCongress\TestTools\Tests\Stubs;

use PHPUnit\Framework\TestCase;
use RichCongress\TestTools\Stubs\Symfony\EventDispatcherStub;
use RichCongress\TestTools\Tests\Resources\Event\DummyEvent;

/**
 * Class EventDispatcherStubTest
 *
 * @package   RichCongress\TestTools\Tests\Stubs
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestTools\Stubs\Symfony\EventDispatcherStub
 */
class EventDispatcherStubTest extends TestCase
{
    /**
     * @var EventDispatcherStub
     */
    protected $eventDispatcher;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->eventDispatcher = new EventDispatcherStub();
    }

    /**
     * @return void
     */
    public function testDispatchReversed(): void
    {
        $event = new DummyEvent();

        $this->eventDispatcher->dispatch('event', $event);

        self::assertContainsEquals($event, $this->eventDispatcher->events);
    }
}
