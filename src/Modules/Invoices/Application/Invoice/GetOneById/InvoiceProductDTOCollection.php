<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

final class InvoiceProductDTOCollection
{
    public function __construct(private array $items = []){}

    public function add(InvoiceProductDTO $invoiceProduct): void
    {
        $this->items[] = $invoiceProduct;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}