<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\BankAccount\Assign;

use App\Common\Application\Command\Command;

final class AssignBankAccountToAccountCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $bankName,
        public readonly string $accountNumber,
        public readonly string $currency,
    ){}
}