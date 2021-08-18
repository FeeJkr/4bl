<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetUserByToken;

final class UserDTO
{
    public function __construct(
        private string $id,
        private string $email,
        private string $username,
        private string $firstName,
        private string $lastName,
    ) {}

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
}
