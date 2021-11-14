<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use DateTimeImmutable;

class InvoiceParametersSnapshot
{
    public function __construct(
        private string $invoiceNumber,
        private string $generatePlace,
        private float $alreadyTakenPrice,
        private string $currencyCode,
        private int $vatPercentage,
        private DateTimeImmutable $generateDate,
        private DateTimeImmutable $sellDate
    ){}

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function getGeneratePlace(): string
    {
        return $this->generatePlace;
    }

    public function getAlreadyTakenPrice(): float
    {
        return $this->alreadyTakenPrice;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getVatPercentage(): int
    {
        return $this->vatPercentage;
    }

    public function getGenerateDate(): DateTimeImmutable
    {
        return $this->generateDate;
    }

    public function getSellDate(): DateTimeImmutable
    {
        return $this->sellDate;
    }
}