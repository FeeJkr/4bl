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
        public readonly string $status,
        public readonly string $companyName,
        public readonly string $contractorName,
        public readonly float $totalNetPrice,
        public readonly float $totalGrossPrice,
        public readonly string $currencyCode,
    ){}

    public static function fromStorage(array $storage): self
    {
        return new self(
            $storage['id'],
            $storage['number'],
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $storage['generated_at']),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $storage['sold_at']),
            $storage['status'],
            $storage['company_name'],
            $storage['contractor_name'],
            (float) $storage['total_net_price'],
            (float) $storage['total_gross_price'],
            $storage['currency_code'],
        );
    }
}
