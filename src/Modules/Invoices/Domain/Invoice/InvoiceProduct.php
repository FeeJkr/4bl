<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use JetBrains\PhpStorm\Pure;

final class InvoiceProduct
{
    public function __construct(
        private InvoiceProductId $id,
        private int $position,
        private string $name,
        private Unit $unit,
        private int $quantity,
        private float $netPrice,
        private Tax $tax,
    ){}

    public function getTaxPrice(): float
    {
        return $this->tax->value === 0
            ? 0
            : ($this->netPrice * $this->tax->value) / 100;
    }

    #[Pure]
    public function getGrossPrice(): float
    {
        return $this->netPrice + $this->getTaxPrice();
    }

    #[Pure]
    public function getSnapshot(): InvoiceProductSnapshot
    {
        return new InvoiceProductSnapshot(
            $this->id->toString(),
            $this->position,
            $this->name,
            $this->unit->value,
            $this->quantity,
            $this->netPrice,
            $this->getTaxPrice(),
            $this->getGrossPrice(),
            $this->tax->value,
        );
    }
}
