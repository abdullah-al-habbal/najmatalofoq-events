<?php
// modules\IAM\Infrastructure\Services\SanctumTokenManager.php
declare(strict_types=1);

namespace Modules\IAM\Infrastructure\Services;

use Modules\IAM\Domain\Service\TokenManager;
use Modules\IAM\Infrastructure\Persistence\Eloquent\UserModel;

final readonly class SanctumTokenManager implements TokenManager
{
    public function __construct(
        private UserModel $model,
    ) {
    }

    public function createToken(string $email, string $tokenName = 'api'): string
    {
        $user = $this->model->newQuery()->where('email', $email)->firstOrFail();

        return $user->createToken($tokenName)->plainTextToken;
    }

    public function revokeAllTokens(string $email): void
    {
        $user = $this->model->newQuery()->where('email', $email)->firstOrFail();

        $user->tokens()->delete();
    }
}
