<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use App\Common\Application\Query\Query;

final class GetInvoiceByIdQuery implements Query
{
    public function __construct(public readonly string $invoiceId){}
}
