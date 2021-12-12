<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

final class InvoiceProductDTOCollection
{
    private array $invoiceProducts;

    public function __construct(InvoiceProductDTO ...$invoiceProducts)
    {
        $this->invoiceProducts = $invoiceProducts;
    }

    public function add(InvoiceProductDTO $invoiceProduct): void
    {
        $this->invoiceProducts[] = $invoiceProduct;
    }

    public function toArray(): array
    {
        return $this->invoiceProducts;
    }
}
