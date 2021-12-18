<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\BankAccount\GetOneById;

use App\Common\Application\Query\Query;

final class GetOneBankAccountByIdQuery implements Query
{
    public function __construct(public readonly string $id){}
}
