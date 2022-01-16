<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

enum Tax: int
{
    case NONE = 0;
    case VAT = 23;
}
