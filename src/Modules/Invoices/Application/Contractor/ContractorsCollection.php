<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor;

final class ContractorsCollection
{
    private array $items;

    public function __construct(ContractorDTO ...$items)
    {
        $this->items = $items;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
