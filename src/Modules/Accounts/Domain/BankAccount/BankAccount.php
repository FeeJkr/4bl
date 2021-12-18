<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\BankAccount;

use App\Common\Domain\Entity;
use App\Modules\Accounts\Domain\User\UserId;

final class BankAccount extends Entity
{
    public function __construct(
        private BankAccountId $id,
        private UserId $userId,
        private string $name,
        private string $bankName,
        private string $accountNumber,
        private Currency $currency,
    ){}

    public function update(
        string $name,
        string $bankName,
        string $accountNumber,
        Currency $currency,
    ): void {
        $this->name = $name;
        $this->bankName = $bankName;
        $this->accountNumber = $accountNumber;
        $this->currency = $currency;
    }
}
