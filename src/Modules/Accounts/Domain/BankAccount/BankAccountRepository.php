<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\BankAccount;

interface BankAccountRepository
{
    public function nextIdentity(): BankAccountId;
    public function findById(BankAccountId $id): BankAccount;
    public function store(BankAccount $bankAccount): void;
    public function save(BankAccount $bankAccount): void;
    public function delete(BankAccountId $id): void;
}
