<?php
declare(strict_types=1);

namespace Modules\IAM\Domain\Repository;

use Modules\IAM\Domain\User;
use Modules\IAM\Domain\ValueObject\UserId;

interface UserRepositoryInterface
{
    public function nextIdentity(): UserId;
    public function save(User $user): void;
    public function findByUuid(string $uuid): ?User;
    public function findByEmail(string $email): ?User;
    public function findById(UserId $id): ?User;
}
