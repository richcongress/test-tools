<?php declare(strict_types=1);

namespace RichCongress\TestTools\Stubs\Symfony;

use RichCongress\TestTools\Tests\Resources\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class SecurityStub
 *
 * @package   RichCongress\TestTools\Stubs\Symfony
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class SecurityStub extends Security
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * SecurityStub constructor.
     */
    public function __construct()
    {
        $this->tokenStorage = new TokenStorage();
        $this->setUser(null);

        $container = new ContainerStub();
        $container->set('security.token_storage', $this->tokenStorage);

        parent::__construct($container);
    }

    /**
     * @param UserInterface $user
     *
     * @param array         $roles
     *
     * @return $this
     */
    public function setUser(?UserInterface $user, array $roles = []): self
    {
        $this->user = $user;
        $this->updateRoles($roles);

        $token = new UsernamePasswordToken($user ?? 'anon.', '', 'security_stub', $roles);
        $this->tokenStorage->setToken($token);

        return $this;
    }

    /**
     * @return array|Role[]
     */
    public function getRoles(): array
    {
        return $this->getToken() !== null
            ? $this->getToken()->getRoles()
            : [];
    }

    /**
     * @param array $roles
     *
     * @return void
     */
    protected function updateRoles(array $roles): void
    {
        if ($this->user === null) {
            return;
        }

        $class = new \ReflectionClass($this->user);
        $property = $class->getProperty('roles');
        $property->setAccessible(true);
        $property->setValue($this->user, $roles);
    }
}
