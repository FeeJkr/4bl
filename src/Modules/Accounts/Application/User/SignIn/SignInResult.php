<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignIn;

use App\Modules\Accounts\Application\User\UserDTO;

final class SignInResult
{
    public function __construct(private UserDTO $user){}

    public function getUser(): UserDTO
    {
        return $this->user;
    }
}