<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use DateTimeImmutable;

final class InvoiceDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $sellerId,
        public readonly string $buyerId,
        public readonly string $invoiceNumber,
        public readonly string $generatePlace,
        public readonly float $alreadyTakenPrice,
        public readonly string $currencyCode,
        public readonly int $vatPercentage,
        public readonly DateTimeImmutable $generatedAt,
        public readonly DateTimeImmutable $soldAt,
        public readonly InvoiceProductDTOCollection $products,
    ){}
}
