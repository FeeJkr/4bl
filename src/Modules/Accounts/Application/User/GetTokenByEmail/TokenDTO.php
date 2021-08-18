<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetTokenByEmail;

final class TokenDTO
{
    public function __construct(private string $accessToken) {}

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}
