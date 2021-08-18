<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

interface TokenRepository
{
    public function store(Token $token, User $user): void;
    public function getByAccessToken(string $accessToken): Token;
}