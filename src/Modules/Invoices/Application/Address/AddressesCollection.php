<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Address;

final class AddressesCollection
{
    private array $items;

    public function __construct(AddressDTO ...$items)
    {
        $this->items = $items;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
