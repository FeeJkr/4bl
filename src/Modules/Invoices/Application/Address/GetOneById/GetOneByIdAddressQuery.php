<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Address\GetOneById;

use App\Common\Application\Query\Query;

final class GetOneByIdAddressQuery implements Query
{
    public function __construct(
        public readonly string $id,
    ){}
}
