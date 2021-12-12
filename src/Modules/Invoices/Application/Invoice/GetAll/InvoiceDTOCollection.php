<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

final class InvoiceDTOCollection
{
    private array $invoices;

    public function __construct(InvoiceDTO ...$invoices)
    {
        $this->invoices = $invoices;
    }

    public function add(InvoiceDTO $invoice): void
    {
        $this->invoices[] = $invoice;
    }

    public function toArray(): array
    {
        return $this->invoices;
    }
}
