<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

final class InvoiceProductsCollection
{
    public readonly array $items;

    public function __construct(InvoiceProductDTO ...$items)
    {
        $this->items = $items;
    }
}
