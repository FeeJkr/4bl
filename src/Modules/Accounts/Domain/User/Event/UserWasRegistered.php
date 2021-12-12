<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User\Event;

use App\Common\Domain\DomainEvent;

final class UserWasRegistered implements DomainEvent
{
    public function __construct(
        public readonly string $email,
        public readonly string $username,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $confirmationToken
    ){}
}
