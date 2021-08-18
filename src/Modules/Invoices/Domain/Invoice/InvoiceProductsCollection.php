<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

class InvoiceProductsCollection
{
    public function __construct(private array $products) {}

    public function getProducts(): array
    {
        return $this->products;
    }

    public function toArray(): array
    {
        return array_map(
            static fn (InvoiceProduct $product): array => $product->toArray(),
            $this->products
        );
    }
}