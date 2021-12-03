<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetById;

use App\Common\Application\Query\Query;

final class GetUserByIdQuery implements Query
{
    public function __construct(public readonly string $userId){}
}
