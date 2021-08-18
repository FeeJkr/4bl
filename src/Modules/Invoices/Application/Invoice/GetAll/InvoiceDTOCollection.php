<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

final class InvoiceDTOCollection
{
    public function __construct(private array $items = []){}

    public function add(InvoiceDTO $invoice): void
    {
        $this->items[] = $invoice;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}