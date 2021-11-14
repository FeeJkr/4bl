<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\Update;

use App\Common\Application\Command\Command;

final class UpdateInvoiceCommand implements Command
{
    public function __construct(
        private string $id,
        private string $invoiceNumber,
        private string $generateDate,
        private string $sellDate,
        private string $generatePlace,
        private string $sellerId,
        private string $buyerId,
        private array $products,
        private float $alreadyTakenPrice,
        private string $currency,
        private int $vatPercentage,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function getGenerateDate(): string
    {
        return $this->generateDate;
    }

    public function getSellDate(): string
    {
        return $this->sellDate;
    }

    public function getGeneratePlace(): string
    {
        return $this->generatePlace;
    }

    public function getSellerId(): string
    {
        return $this->sellerId;
    }

    public function getBuyerId(): string
    {
        return $this->buyerId;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getAlreadyTakenPrice(): float
    {
        return $this->alreadyTakenPrice;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getVatPercentage(): int
    {
        return $this->vatPercentage;
    }
}
