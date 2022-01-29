<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

enum VatRejectionReason: int
{
    case EXEMPTION_BY_LESS_THAN_MINIMAL_ANNUAL_TURNOVER = 1;
    case EXEMPTION_BY_MF_DISPOSITION = 2;
    case EXEMPTION_BY_TYPE_OF_BUSINESS = 3;
}
