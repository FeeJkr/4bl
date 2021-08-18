<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use DateTimeImmutable;

final class UserSnapshot
{
    public function __construct(
        private string $id,
        private string $email,
        private string $username,
        private string $firstName,
        private string $lastName,
        private ?string $accessToken,
        private ?string $refreshToken,
        private ?DateTimeImmutable $refreshTokenExpiresAt
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function getRefreshTokenExpiresAt(): ?DateTimeImmutable
    {
        return $this->refreshTokenExpiresAt;
    }
}