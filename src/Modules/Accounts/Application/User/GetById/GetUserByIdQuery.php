<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetById;

class GetUserByIdQuery implements \App\Common\Application\Query\Query
{
    public function __construct(private string $userId){}

    public function getUserId(): string
    {
        return $this->userId;
    }
}