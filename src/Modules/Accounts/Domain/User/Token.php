<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use DateTimeImmutable;

final class Token
{
    public function __construct(
        private string $accessToken,
        private string $refreshToken,
        private DateTimeImmutable $refreshTokenExpiresAt
    ){}

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getRefreshTokenExpiresAt(): DateTimeImmutable
    {
        return $this->refreshTokenExpiresAt;
    }
}
