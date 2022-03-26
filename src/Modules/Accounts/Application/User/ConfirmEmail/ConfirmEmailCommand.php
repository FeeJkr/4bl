<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\ConfirmEmail;

use App\Common\Application\Command\Command;

final class ConfirmEmailCommand implements Command
{
    public function __construct(public readonly string $token){}
}
