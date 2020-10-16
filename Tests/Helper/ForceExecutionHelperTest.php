<?php declare(strict_types=1);

namespace RichCongress\TestTools\Tests\Helper;

use RichCongress\TestTools\Helper\ForceExecutionHelper;
use RichCongress\TestTools\TestCase\TestCase;
use RichCongress\TestTools\Tests\Resources\Entity\DummyEntity;

/**
 * Class ForceExecutionHelperTest
 *
 * @package   RichCongress\TestTools\Tests\Helper
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestTools\Helper\ForceExecutionHelper
 */
class ForceExecutionHelperTest extends TestCase
{
    public function testCannotInstanciateHelper(): void
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Call to private RichCongress\TestTools\Helper\ForceExecutionHelper::__construct()');

        new ForceExecutionHelper();
    }

    public function testExecuteMethod(): void
    {
        $object = new DummyEntity();
        $returned = ForceExecutionHelper::executeMethod($object, 'setName', ['ThisIsATest']);

        self::assertSame($object, $returned);
        self::assertEquals('ThisIsATest', $object->getName());
    }

    public function testExecuteMethodWithBadObject(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cannot call a non static method without the instanciated object for ' . DummyEntity::class);

        ForceExecutionHelper::executeMethod(DummyEntity::class, 'setName', ['ThisIsATest']);
    }

    public function testExecuteStaticMethodWithInstanciatedObject(): void
    {
        $object = new DummyEntity();
        ForceExecutionHelper::executeMethod($object, 'setStaticName', ['ThisIsATest']);

        self::assertEquals('ThisIsATest', DummyEntity::getStaticName());
    }

    public function testExecuteStaticMethodWithClassName(): void
    {
        ForceExecutionHelper::executeMethod(DummyEntity::class, 'setStaticName', ['ThisIsATest']);

        self::assertEquals('ThisIsATest', DummyEntity::getStaticName());
    }

    public function testSetValue(): void
    {
        $object = new DummyEntity();
        ForceExecutionHelper::setValue($object, 'name', 'ThisIsATest');

        self::assertEquals('ThisIsATest', $object->getName());
    }

    public function testSetValueWithBadObject(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cannot call a non static property without the instanciated object for ' . DummyEntity::class);

        ForceExecutionHelper::setValue(DummyEntity::class, 'name', 'ThisIsATest');
    }

    public function testSetStaticValueWithInstanciatedObject(): void
    {
        $object = new DummyEntity();
        ForceExecutionHelper::setValue($object, 'staticName', 'ThisIsATest');

        self::assertEquals('ThisIsATest', DummyEntity::getStaticName());
    }

    public function testSetStaticValueWithClassName(): void
    {
        ForceExecutionHelper::setValue(DummyEntity::class, 'staticName', 'ThisIsATest');

        self::assertEquals('ThisIsATest', DummyEntity::getStaticName());
    }

    public function testWithBadObjectType(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('he first argument must be an object or a class name, double given.');

        ForceExecutionHelper::setValue(0.1, 'staticName', 'ThisIsATest');
    }
}
