<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

final class InvoicesCollection
{
    public readonly array $items;

    public function __construct(InvoiceDTO ...$items)
    {
        $this->items = $items;
    }
}
