<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use DateTimeImmutable;

final class InvoiceDTO
{
    public function __construct(
        private string $id,
        private string $userId,
        private string $sellerId,
        private string $buyerId,
        private string $invoiceNumber,
        private string $generatePlace,
        private float $alreadyTakenPrice,
        private string $currencyCode,
        private DateTimeImmutable $generatedAt,
        private DateTimeImmutable $soldAt,
        private InvoiceProductDTOCollection $products,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getSellerId(): string
    {
        return $this->sellerId;
    }

    public function getBuyerId(): string
    {
        return $this->buyerId;
    }

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

    public function getGeneratedAt(): DateTimeImmutable
    {
        return $this->generatedAt;
    }

    public function getSoldAt(): DateTimeImmutable
    {
        return $this->soldAt;
    }

    public function getProducts(): InvoiceProductDTOCollection
    {
        return $this->products;
    }
}