<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

final class UserSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $username,
        public readonly string $password,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $status,
        public readonly ?string $confirmationToken
    ){}
}
