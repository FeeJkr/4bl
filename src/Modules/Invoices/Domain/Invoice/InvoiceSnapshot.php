<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

final class InvoiceSnapshot
{
    public function __construct(
        private string $id,
        private string $userId,
        private string $sellerId,
        private string $buyerId,
        private InvoiceParametersSnapshot $parameters,
        private array $products,
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

    public function getParameters(): InvoiceParametersSnapshot
    {
        return $this->parameters;
    }

    /**
     * @return array<int, InvoiceProductSnapshot>
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}