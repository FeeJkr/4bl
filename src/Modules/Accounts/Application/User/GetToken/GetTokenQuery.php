<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetToken;

use App\Common\Application\Query\Query;

final class GetTokenQuery implements Query
{
    public function __construct(private string $email) {}

    public function getEmail(): string
    {
        return $this->email;
    }
}
