<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignIn;

use App\Common\Application\Command\Command;

final class SignInUserCommand implements Command
{
    public function __construct(public readonly string $email, public readonly string $password) {}
}
