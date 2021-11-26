<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User\Event;

use App\Common\Domain\DomainEvent;

final class UserWasRegistered implements DomainEvent
{
    public function __construct(
        private string $email,
        private string $username,
        private string $firstName,
        private string $lastName,
        private string $confirmationToken
    ){}

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

    public function getConfirmationToken(): string
    {
        return $this->confirmationToken;
    }
}