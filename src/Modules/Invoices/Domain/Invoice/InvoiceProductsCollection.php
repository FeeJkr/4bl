<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

class InvoiceProductsCollection
{
    private array $products;

    public function __construct(InvoiceProduct ...$products)
    {
        $this->products = $products;
    }

    public function toArray(): array
    {
        return $this->products;
    }
}
