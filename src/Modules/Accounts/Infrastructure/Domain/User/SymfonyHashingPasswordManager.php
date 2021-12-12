<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User;

use App\Modules\Accounts\Domain\User\PasswordManager;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final class SymfonyHashingPasswordManager implements PasswordManager
{
    private PasswordHasherInterface $passwordHasher;

    public function __construct()
    {
        $this->passwordHasher = new NativePasswordHasher();
    }

    public function hash(string $plainPassword): string
    {
        return $this->passwordHasher->hash($plainPassword);
    }

    public function isValid(string $plainPassword, string $hashedPassword): bool
    {
        return $this->passwordHasher->verify($hashedPassword, $plainPassword);
    }
}
