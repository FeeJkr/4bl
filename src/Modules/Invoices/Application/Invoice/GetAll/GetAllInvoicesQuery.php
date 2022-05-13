<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

use App\Common\Application\Query\Query;
use DateTimeImmutable;

final class GetAllInvoicesQuery implements Query
{
    public function __construct(
        public readonly ?DateTimeImmutable $generatedAtFilter,
    ){}
}
