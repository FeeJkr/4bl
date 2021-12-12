<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

final class InvoiceProductDTO
{
    public function __construct(
        public readonly string $id,
        public readonly int $position,
        public readonly string $name,
        public readonly float $price,
    ){}
}
