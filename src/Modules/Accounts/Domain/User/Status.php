<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use MyCLabs\Enum\Enum;

/**
 * @method static Status ACTIVE()
 * @method static Status EMAIL_VERIFICATION()
 * @method static Status DISABLE()
 */
final class Status extends Enum
{
    private const ACTIVE = 'active';
    private const EMAIL_VERIFICATION = 'email_verification';
    private const DISABLE = 'disable';
}