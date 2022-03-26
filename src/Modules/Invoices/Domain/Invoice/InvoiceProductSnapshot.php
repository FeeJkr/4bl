<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

final class InvoiceProductSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly int $position,
        public readonly string $name,
        public readonly string $unit,
        public readonly int $quantity,
        public readonly float $netPrice,
        public readonly float $taxPrice,
        public readonly float $grossPrice,
        public readonly int $tax,
    ){}
}
