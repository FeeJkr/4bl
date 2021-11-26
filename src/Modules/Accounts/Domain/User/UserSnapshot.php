<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

final class UserSnapshot
{
    public function __construct(
        private string $id,
        private string $email,
        private string $username,
        private string $password,
        private string $firstName,
        private string $lastName,
        private string $status,
        private ?string $confirmationToken
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }
}