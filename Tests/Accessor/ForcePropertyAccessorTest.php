<?php declare(strict_types=1);

namespace RichCongress\TestTools\Tests\Accessor;

use PHPUnit\Framework\TestCase;
use RichCongress\TestTools\Accessor\ForcePropertyAccessor;
use RichCongress\TestTools\Tests\Resources\Entity\DummyEntity;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;

/**
 * Class ForcePropertyAccessorTest
 *
 * @package    RichCongress\TestTools\Tests\Accessor
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestTools\Accessor\ForcePropertyAccessor
 */
final class ForcePropertyAccessorTest extends TestCase
{
    /** @var ForcePropertyAccessor */
    private $propertyAccessor;

    public function setUp(): void
    {
        $this->propertyAccessor = new ForcePropertyAccessor();
    }

    public function testIsWritableAndReadable(): void
    {
        self::assertTrue($this->propertyAccessor->isReadable([], ''));
        self::assertTrue($this->propertyAccessor->isWritable([], ''));
    }

    public function testSetValueForArray(): void
    {
        $object = [];
        $this->propertyAccessor->setValue($object, '[test]', true);

        self::assertArrayHasKey('test', $object);
        self::assertTrue($object['test']);
    }

    public function testGetValueForArray(): void
    {
        $object = ['test' => true];
        self::assertTrue($this->propertyAccessor->getValue($object, '[test]'));
    }

    public function testSetValueArrayWithException(): void
    {
        $this->expectException(NoSuchPropertyException::class);

        $object = [];
        $this->propertyAccessor->setValue($object, 'bad', true);
    }

    public function testGetValueArrayWithException(): void
    {
        $this->expectException(NoSuchPropertyException::class);

        $object = [];
        $this->propertyAccessor->getValue($object, 'bad');
    }

    public function testSetValueWithException(): void
    {
        $this->expectException(NoSuchPropertyException::class);

        $object = new DummyEntity();
        $this->propertyAccessor->setValue($object, 'NotExisting', true);
    }

    public function testGetValueWithException(): void
    {
        $this->expectException(NoSuchPropertyException::class);

        $object = new DummyEntity();
        $this->propertyAccessor->getValue($object, 'NotExisting');
    }

    public function testSetGetValueForObjectUsingMethod(): void
    {
        $object = new DummyEntity();

        $this->propertyAccessor->setValue($object, 'name', 'Name');
        self::assertEquals('Name', $this->propertyAccessor->getValue($object, 'name'));
    }

    public function testSetGetValueForObjectDirectProperty(): void
    {
        $object = new DummyEntity();

        $this->propertyAccessor->setValue($object, 'privateVariable', 'Name');
        self::assertEquals('Name', $this->propertyAccessor->getValue($object, 'privateVariable'));
    }

    public function testSetGetStaticValueForObjectDirectProperty(): void
    {
        $object = new DummyEntity();

        $this->propertyAccessor->setValue($object, 'staticName', 'Name');
        self::assertEquals('Name', $this->propertyAccessor->getValue($object, 'staticName'));
    }

    public function testSetGetStaticValueForObjectUsingMethod(): void
    {
        $object = new DummyEntity();

        $this->propertyAccessor->setValue($object, 'protectedVariable', 'Name');
        self::assertEquals('Name', $this->propertyAccessor->getValue($object, 'protectedVariable'));
    }
}
