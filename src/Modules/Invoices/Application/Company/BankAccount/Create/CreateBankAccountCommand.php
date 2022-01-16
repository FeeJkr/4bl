<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\BankAccount\Create;

use App\Common\Application\Command\Command;

final class CreateBankAccountCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $bankName,
        public readonly string $bankAccountNumber,
        public readonly string $currency
    ){}
}
