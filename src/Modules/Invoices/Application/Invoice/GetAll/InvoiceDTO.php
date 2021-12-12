<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

use DateTimeImmutable;

final class InvoiceDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $invoiceNumber,
        public readonly DateTimeImmutable $generatedAt,
        public readonly DateTimeImmutable $soldAt,
        public readonly string $sellerName,
        public readonly string $buyerName,
        public readonly float $totalNetPrice,
        public readonly string $currencyCode,
        public readonly int $vatPercentage,
    ){}
}
