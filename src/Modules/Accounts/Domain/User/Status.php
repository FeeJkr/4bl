<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

enum Status: string
{
    case ACTIVE = 'active';
    case EMAIL_VERIFICATION = 'email_verification';
    case DISABLE = 'disable';
}