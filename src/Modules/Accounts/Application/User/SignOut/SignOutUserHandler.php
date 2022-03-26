<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignOut;

use App\Common\Application\Command\CommandHandler;

final class SignOutUserHandler implements CommandHandler
{
    public function __construct() {}

    public function __invoke(SignOutUserCommand $command): void
    {
    }
}
