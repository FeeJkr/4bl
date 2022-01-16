<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

enum PaymentType: string
{
    case BANK_TRANSFER = 'bank_transfer';
    case CASH = 'cash';
}
