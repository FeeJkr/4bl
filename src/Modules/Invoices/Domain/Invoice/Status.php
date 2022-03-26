<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

enum Status: string
{
    case DRAFT = 'draft';
    case SEND = 'send';
    case PAID = 'paid';
}
