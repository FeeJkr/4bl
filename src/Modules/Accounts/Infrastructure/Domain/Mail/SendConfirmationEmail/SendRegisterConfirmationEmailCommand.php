<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\Mail\SendConfirmationEmail;

use App\Common\Application\Command\Command;

final class SendRegisterConfirmationEmailCommand implements Command
{
    public function __construct(
        public readonly string $email,
        public readonly string $username,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $confirmationToken
    ){}
}
