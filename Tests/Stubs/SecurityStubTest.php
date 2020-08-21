<?php declare(strict_types=1);

namespace RichCongress\UnitTestBundle\Tests\Stubs;

use PHPUnit\Framework\TestCase;
use RichCongress\UnitTestBundle\Stubs\SecurityStub;
use RichCongress\UnitTestBundle\Tests\Resources\Entity\User;

/**
 * Class SecurityStubTest
 *
 * @package   RichCongress\UnitTestBundle\Tests\Stubs
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\UnitTestBundle\Stubs\SecurityStub
 */
class SecurityStubTest extends TestCase
{
    /**
     * @var SecurityStub
     */
    protected $security;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->security = new SecurityStub();
    }

    /**
     * @return void
     */
    public function testSetUser(): void
    {
        $user = new User();
        $this->security->setUser($user, ['ROLE_MAGIC']);
        $roles = $this->security->getRoles();

        self::assertSame($user, $this->security->getUser());
        self::assertCount(1, $roles);
        self::assertEquals('ROLE_MAGIC', $roles[0]->getRole());
    }

    /**
     * @return void
     */
    public function testSetEmptyUser(): void
    {
        $this->security->setUser(null, ['ROLE_MAGIC']);
        $roles = $this->security->getRoles();

        self::assertNull($this->security->getUser());
        self::assertCount(1, $roles);
        self::assertEquals('ROLE_MAGIC', $roles[0]->getRole());
    }
}
