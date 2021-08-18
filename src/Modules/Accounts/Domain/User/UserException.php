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
    public static function notFoundByToken(Token $token): self
    {
        return new self(sprintf('User with token %s not found.', $token->toString()));
    }

    #[Pure]
    public static function notFoundByAccessToken(): self
    {
        return new self('Access token is invalid.');
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
    public static function emptyToken(): self
    {
        return new self('User access or refresh token is empty. Invalid state');
    }
}
