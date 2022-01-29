<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\BankAccount;

use App\Modules\Invoices\Domain\User\UserId;

interface BankAccountRepository
{
    public function nextIdentity(): BankAccountId;

    public function fetchById(BankAccountId $id, UserId $userId): BankAccount;

    public function store(BankAccountSnapshot $snapshot): void;
    public function save(BankAccountSnapshot $snapshot): void;
    public function delete(BankAccountId $id, UserId $userId): void;
}
