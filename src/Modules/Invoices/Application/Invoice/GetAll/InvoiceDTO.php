<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

use DateTimeImmutable;

final class InvoiceDTO
{
    public function __construct(
        private string $id,
        private string $invoiceNumber,
        private DateTimeImmutable $generatedAt,
        private DateTimeImmutable $soldAt,
        private string $sellerName,
        private string $buyerName,
        private float $totalNetPrice,
        private string $currencyCode,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function getGeneratedAt(): DateTimeImmutable
    {
        return $this->generatedAt;
    }

    public function getSoldAt(): DateTimeImmutable
    {
        return $this->soldAt;
    }

    public function getSellerName(): string
    {
        return $this->sellerName;
    }

    public function getBuyerName(): string
    {
        return $this->buyerName;
    }

    public function getTotalNetPrice(): float
    {
        return $this->totalNetPrice;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }
}