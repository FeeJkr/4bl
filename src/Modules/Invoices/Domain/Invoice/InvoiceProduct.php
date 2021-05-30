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
        private ?Invoice $invoice,
        private int $position,
        private string $name,
        private float $netPrice,
        private DateTimeImmutable $createdAt,
        private ?DateTimeImmutable $updatedAt
    ){}

    public function getId(): InvoiceProductId
    {
        return $this->id;
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
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
        return ($this->netPrice * 23) / 100;
    }

    #[Pure]
    public function getGrossPrice(): float
    {
        return $this->netPrice + $this->getTaxPrice();
    }

    #[Pure]
    #[ArrayShape(['name' => "string", 'netPrice' => "float", 'taxPrice' => "float", 'grossPrice' => "float"])]
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'netPrice' => $this->getNetPrice(),
            'taxPrice' => $this->getTaxPrice(),
            'grossPrice' => $this->getGrossPrice(),
        ];
    }
}