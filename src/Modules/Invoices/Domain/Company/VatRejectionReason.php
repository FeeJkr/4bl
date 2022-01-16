<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

enum VatRejectionReason: int
{
    case LESS_THAN_MINIMAL_ANNUAL_TURNOVER = 1;
}
