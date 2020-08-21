<?php declare(strict_types=1);

namespace RichCongress\UnitTestBundle\Tests\Stubs;

use PHPUnit\Framework\TestCase;
use RichCongress\UnitTestBundle\Stubs\RepositoryStub;
use RichCongress\UnitTestBundle\Tests\Resources\Entity\DummyEntity;

/**
 * Class RepositoryStubTest
 *
 * @package   RichCongress\UnitTestBundle\Tests\Stubs
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\UnitTestBundle\Stubs\RepositoryStub
 */
class RepositoryStubTest extends TestCase
{
    /**
     * @var RepositoryStub
     */
    protected $repository;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new RepositoryStub(DummyEntity::class);
    }

    /**
     * @return void
     */
    public function testGetManagerGetClassName(): void
    {
        $entityManager = $this->repository->getManager();

        self::assertSame(DummyEntity::class, $this->repository->getClassName());
        self::assertSame($this->repository, $entityManager->getRepository(DummyEntity::class));
    }

    /**
     * @return void
     */
    public function testFindFindOneBy(): void
    {
        $entity1 = DummyEntity::createFromId(1);
        $entity2 = DummyEntity::createFromId(2);

        $entityManager = $this->repository->getManager();
        $entityManager->addEntity($entity1);
        $entityManager->addEntity($entity2);

        self::assertSame($entity2, $this->repository->find(2));
        self::assertNull($this->repository->find(3));
    }

    /**
     * @return void
     */
    public function testFindBy(): void
    {
        $entity1 = DummyEntity::createFromKeyname('keyname_1');
        $entity2 = DummyEntity::createFromKeyname('keyname_2');
        $entity3 = DummyEntity::createFromKeyname('keyname_1');

        $entityManager = $this->repository->getManager();
        $entityManager->addEntity($entity1);
        $entityManager->addEntity($entity2);
        $entityManager->addEntity($entity3);

        $results = $this->repository->findBy(['keyname' => 'keyname_1']);
        self::assertContainsEquals($entity1, $results);
        self::assertNotContainsEquals($entity2, $results);
        self::assertContainsEquals($entity3, $results);
    }
}
