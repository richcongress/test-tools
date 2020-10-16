<?php declare(strict_types=1);

namespace RichCongress\TestTools\Tests\Stubs;

use PHPUnit\Framework\TestCase;
use RichCongress\TestTools\Stubs\Symfony\EntityManagerStub;
use RichCongress\TestTools\Stubs\Symfony\RepositoryStub;
use RichCongress\TestTools\Tests\Resources\Entity\DummyEntity;

/**
 * Class EntityManagerStubTest
 *
 * @package   RichCongress\TestTools\Tests\Stubs
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestTools\Stubs\Symfony\EntityManagerStub
 */
class EntityManagerStubTest extends TestCase
{
    /**
     * @var EntityManagerStub
     */
    protected $entityManager;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->entityManager = new EntityManagerStub();
    }

    /**
     * @return void
     */
    public function testFlush(): void
    {
        self::assertSame(0, $this->entityManager->flushCount);

        $this->entityManager->flush();

        self::assertSame(1, $this->entityManager->flushCount);

    }

    /**
     * @return void
     */
    public function testPersist(): void
    {
        self::assertEmpty($this->entityManager->persisted);

        $entity = new DummyEntity();
        $this->entityManager->persist($entity);

        self::assertArrayHasKey(DummyEntity::class, $this->entityManager->persisted);
        self::assertContainsEquals($entity, $this->entityManager->persisted[DummyEntity::class]);
    }

    public function testRemove(): void
    {
        self::assertEmpty($this->entityManager->deleted);

        $entity = new DummyEntity();
        $this->entityManager->remove($entity);

        self::assertArrayHasKey(DummyEntity::class, $this->entityManager->deleted);
        self::assertContainsEquals($entity, $this->entityManager->deleted[DummyEntity::class]);
    }

    /**
     * @return void
     */
    public function testSetGetRepositoryFindEntity(): void
    {
        $repository = new RepositoryStub(DummyEntity::class, $this->entityManager);
        $this->entityManager->setRepository($repository);

        $repositoryFound = $this->entityManager->getRepository(DummyEntity::class);

        self::assertSame($repositoryFound, $repository);

        $entity1 = DummyEntity::createFromId(1);
        $entity2 = DummyEntity::createFromId(2);

        $this->entityManager->addEntity($entity1);
        $this->entityManager->addEntity($entity2);

        self::assertSame($entity2, $this->entityManager->find(DummyEntity::class, 2));
        self::assertNull($this->entityManager->find(DummyEntity::class, 3));
    }

    /**
     * @return void
     */
    public function testEmptyFunctions(): void
    {
        $classMetadata = $this->entityManager->getClassMetadata(DummyEntity::class);

        self::assertSame(DummyEntity::class, $classMetadata->getName());
    }
}
