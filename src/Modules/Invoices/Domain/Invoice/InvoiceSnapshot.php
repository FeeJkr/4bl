<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

final class InvoiceSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $companyId,
        public readonly string $contractorId,
        public readonly string $status,
        public readonly InvoiceParametersSnapshot $parameters,
        public readonly array $products,
    ){}
}
