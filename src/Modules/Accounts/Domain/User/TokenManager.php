<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

interface TokenManager
{
    public function generate(string $email, string $password): Token;

    /**
     * @throws TokenException
     */
    public function validate(string $accessToken): void;
    public function refresh(string $refreshToken): Token;
}
