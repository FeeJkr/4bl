<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use DateTimeImmutable;

final class InvoiceParametersSnapshot
{
    public function __construct(
        public readonly string $invoiceNumber,
        public readonly string $generatePlace,
        public readonly float $alreadyTakenPrice,
        public readonly int $daysForPayment,
        public readonly string $paymentType,
        public readonly ?string $bankAccountId,
        public readonly string $currencyCode,
        public readonly DateTimeImmutable $generatedAt,
        public readonly DateTimeImmutable $soldAt
    ){}
}
