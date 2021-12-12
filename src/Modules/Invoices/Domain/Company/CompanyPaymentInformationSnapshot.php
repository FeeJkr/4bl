<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company;

final class CompanyPaymentInformationSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $paymentType,
        public readonly int $paymentLastDay,
        public readonly string $bank,
        public readonly string $accountNumber,
    ){}
}
