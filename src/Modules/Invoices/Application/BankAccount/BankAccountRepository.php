<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\BankAccount;

interface BankAccountRepository
{
    public function getAll(string $userId): BankAccountsCollection;
    public function getById(string $id, string $userId): BankAccountDTO;
}