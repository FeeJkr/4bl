<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use DateTimeImmutable;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class InvoiceProduct
{
    public function __construct(
        private InvoiceProductId $id,
        private int $position,
        private string $name,
        private float $netPrice,
    ){}

    public function getTaxPrice(): float
    {
        return ($this->netPrice * 23) / 100;
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
            $this->netPrice,
            $this->getTaxPrice(),
            $this->getGrossPrice(),
        );
    }
}