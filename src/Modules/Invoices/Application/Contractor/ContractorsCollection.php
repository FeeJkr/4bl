<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor;

final class ContractorsCollection
{
    public readonly array $items;

    public function __construct(ContractorDTO ...$items)
    {
        $this->items = $items;
    }
}
