<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\BankAccount;

final class BankAccountsCollection
{
    private array $items;

    public function __construct(BankAccountDTO ...$items)
    {
        $this->items = $items;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
