<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use App\Modules\Accounts\Domain\DomainException;
use JetBrains\PhpStorm\Pure;

final class UserException extends DomainException
{
    #[Pure]
    public static function withInvalidCredentials(): self
    {
        return new self('Invalid credentials.');
    }

    #[Pure]
    public static function notFoundByConfirmToken(): self
    {
        return new self('Confirmation token is expired or your account already active.');
    }

    #[Pure]
    public static function alreadyExists(): self
    {
        return new self('Users with given email or username already exists');
    }

    #[Pure]
    public static function notFoundByEmail(string $email): self
    {
        return new self(sprintf('User with email %s not found.', $email));
    }

    #[Pure]
    public static function unprocessableCondition(): self
    {
        return new self('Unprocessable entity condition.');
    }
}
