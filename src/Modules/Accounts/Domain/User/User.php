<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use App\Common\Domain\Entity;
use JetBrains\PhpStorm\Pure;

final class User extends Entity
{
    public function __construct(
        private UserId $id,
        private string $email,
        private string $username,
        private string $firstName,
        private string $lastName,
        private ?Token $token = null
    ){}

    public static function register(
        string $email,
        string $username,
        string $firstName,
        string $lastName,
    ): self {
        return new self(
            UserId::generate(),
            $email,
            $username,
            $firstName,
            $lastName,
        );
    }

    public function signIn(TokenManager $tokenManager, string $password): void
    {
        $this->token = $tokenManager->generate($this->email, $password);
    }

    public function signOut(): void
    {
        $this->token = null;
    }

    /**
     * @throws UserException
     */
    public function refreshToken(TokenManager $tokenManager): void
    {
        if ($this->token === null) {
            throw UserException::emptyToken();
        }

        $this->token = $tokenManager->refresh($this->token->getRefreshToken());
    }

    #[Pure]
    public function getSnapshot(): UserSnapshot
    {
        return new UserSnapshot(
            $this->id->toString(),
            $this->email,
            $this->username,
            $this->firstName,
            $this->lastName,
            $this->token?->getAccessToken(),
            $this->token?->getRefreshToken(),
            $this->token?->getRefreshTokenExpiresAt(),
        );
    }
}
