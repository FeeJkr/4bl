<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\User;

interface UserContext
{
    public function getUserId(): UserId;
}
