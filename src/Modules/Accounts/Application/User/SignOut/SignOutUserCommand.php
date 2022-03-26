<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignOut;

use App\Common\Application\Command\Command;

final class SignOutUserCommand implements Command
{
    public function __construct(public readonly string $token) {}
}
