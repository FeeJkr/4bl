<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

final class InvoiceProductSnapshot
{
    public function __construct(
        private string $id,
        private int $position,
        private string $name,
        private float $netPrice,
        private float $taxPrice,
        private float $grossPrice,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNetPrice(): float
    {
        return $this->netPrice;
    }

    public function getTaxPrice(): float
    {
        return $this->taxPrice;
    }

    public function getGrossPrice(): float
    {
        return $this->grossPrice;
    }
}