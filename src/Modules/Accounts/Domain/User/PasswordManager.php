<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

interface PasswordManager
{
    public function hash(string $plainPassword): string;
    public function isValid(string $plainPassword, string $hashedPassword): bool;
}
