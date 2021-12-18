<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\BankAccount;

final class BankAccountDTOCollection
{
    private array $bankAccounts;

    public function __construct(BankAccountDTO ...$bankAccounts)
    {
        $this->bankAccounts = $bankAccounts;
    }

    public function toArray(): array
    {
        return $this->bankAccounts;
    }
}