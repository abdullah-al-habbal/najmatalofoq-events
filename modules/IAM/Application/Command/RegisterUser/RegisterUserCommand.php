<?php
declare(strict_types=1);

namespace Modules\IAM\Application\Command\RegisterUser;

final readonly class RegisterUserCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
