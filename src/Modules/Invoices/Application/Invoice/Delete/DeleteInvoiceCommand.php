<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Delete;

use App\Common\Application\Command\Command;

final class DeleteInvoiceCommand implements Command
{
    public function __construct(public readonly string $invoiceId){}
}
