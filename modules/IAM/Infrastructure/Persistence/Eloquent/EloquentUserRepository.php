<?php
declare(strict_types=1);

namespace Modules\IAM\Infrastructure\Persistence\Eloquent;

use Modules\IAM\Domain\Repository\UserRepositoryInterface;
use Modules\IAM\Domain\User;
use Modules\IAM\Domain\ValueObject\UserId;
use Modules\IAM\Infrastructure\Persistence\UserReflector;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function nextIdentity(): UserId
    {
        return UserId::generate();
    }

    public function save(User $user): void
    {
        $model = UserModel::updateOrCreate(
            ['uuid' => $user->uuid->value],
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password->value,
                'created_at' => $user->createdAt,
                'updated_at' => $user->updatedAt,
            ]
        );

        // Sync roles
        $roleUuids = array_map(fn($roleId) => $roleId->value, $user->roleIds);
        $model->roles()->sync($roleUuids);
    }

    public function findByUuid(string $uuid): ?User
    {
        $model = UserModel::with('roles')->where('uuid', $uuid)->first();
        return $model ? UserReflector::fromModel($model) : null;
    }

    public function findByEmail(string $email): ?User
    {
        $model = UserModel::with('roles')->where('email', $email)->first();
        return $model ? UserReflector::fromModel($model) : null;
    }

    public function findById(UserId $id): ?User
    {
        return $this->findByUuid($id->value);
    }
}
