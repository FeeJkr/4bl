<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use JetBrains\PhpStorm\Pure;

final class InvoiceProductDTO
{
    public function __construct(
        public readonly string $id,
        public readonly int $position,
        public readonly string $name,
        public readonly string $unit,
        public readonly int $quantity,
        public readonly float $netPrice,
        public readonly float $grossPrice,
        public readonly int $taxPercentage,
    ){}

    #[Pure]
    public static function fromStorage(array $storage): self
    {
        return new self(
            $storage['id'],
            (int) $storage['position'],
            $storage['name'],
            $storage['unit'],
            (int) $storage['quantity'],
            (float) $storage['net_price'],
            (float) $storage['gross_price'],
            (int) $storage['tax_percentage'],
        );
    }
}
