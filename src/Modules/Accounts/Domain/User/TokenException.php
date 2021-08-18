<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use Exception;
use JetBrains\PhpStorm\Pure;

final class TokenException extends Exception
{
    #[Pure]
    public static function mustBeRefreshed(): self
    {
        return new self('Token must be refreshed.');
    }

    #[Pure]
    public static function invalid(): self
    {
        return new self('Token is invalid.');
    }
}