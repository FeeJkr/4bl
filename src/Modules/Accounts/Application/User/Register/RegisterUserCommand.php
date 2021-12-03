<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\Register;

use App\Common\Application\Command\Command;

final class RegisterUserCommand implements Command
{
    public function __construct(
        public readonly string $email,
        public readonly string $username,
        public readonly string $password,
        public readonly string $firstName,
        public readonly string $lastName,
    ){}
}
