<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\BankAccount;

final class BankAccountsCollection
{
    public readonly array $items;

    public function __construct(BankAccountDTO ...$items)
    {
        $this->items = $items;
    }
}
