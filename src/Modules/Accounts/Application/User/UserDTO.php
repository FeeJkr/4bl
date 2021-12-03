<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User;

final class UserDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $username,
        public readonly string $firstName,
        public readonly string $lastName,
    ) {}
}
