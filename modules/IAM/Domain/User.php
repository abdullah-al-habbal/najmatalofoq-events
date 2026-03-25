<?php
declare(strict_types=1);

namespace Modules\IAM\Domain;

use DateTimeImmutable;
use Modules\IAM\Domain\Event\UserRegistered;
use Modules\IAM\Domain\ValueObject\HashedPassword;
use Modules\IAM\Domain\ValueObject\UserId;
use Modules\IAM\Domain\ValueObject\RoleId;
use Modules\Shared\Domain\AggregateRoot;
use Modules\Shared\Domain\Identity;

final class User extends AggregateRoot
{
    private function __construct(
        public readonly UserId $uuid,
        public readonly string $name,
        public readonly string $email,
        public private(set) HashedPassword $password,
        /** @var list<RoleId> */
        public private(set) array $roleIds,
        public readonly DateTimeImmutable $createdAt,
        public private(set) ?DateTimeImmutable $updatedAt = null,
    ) {}

    public static function register(
        UserId $uuid,
        string $name,
        string $email,
        HashedPassword $password,
        array $roleIds,
        DateTimeImmutable $createdAt,
    ): self {
        $user = new self(
            uuid: $uuid,
            name: $name,
            email: $email,
            password: $password,
            roleIds: $roleIds,
            createdAt: $createdAt,
        );
        $user->recordEvent(new UserRegistered($uuid, $email));
        return $user;
    }

    public function hasRole(RoleId $roleId): bool
    {
        foreach ($this->roleIds as $id) {
            if ($id->equals($roleId)) return true;
        }
        return false;
    }

    public function assignRole(RoleId $roleId): void
    {
        if (!$this->hasRole($roleId)) {
            $this->roleIds[] = $roleId;
            $this->updatedAt = new DateTimeImmutable;
        }
    }

    public function changePassword(HashedPassword $password): void
    {
        $this->password = $password;
        $this->updatedAt = new DateTimeImmutable;
    }

    public function id(): Identity
    {
        return $this->uuid;
    }
}
