<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use Ramsey\Uuid\Uuid;

final class ConfirmationToken
{
    public function __construct(public readonly string $token){}

    public static function generate(): self
    {
        return new self(
            Uuid::uuid4()->toString()
        );
    }
}