<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

enum Unit: string
{
    case PIECES = 'pieces';
    case SERVICE = 'service';
}
