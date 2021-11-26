<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\ConfirmEmail;

use App\Common\Application\Command\Command;

class ConfirmEmailCommand implements Command
{
    public function __construct(private string $token){}

    public function getToken(): string
    {
        return $this->token;
    }
}