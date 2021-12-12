<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\User;

interface UserContext
{
    public function getUserId(): UserId;
}
