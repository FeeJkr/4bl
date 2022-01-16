<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Company\BankAccount;

final class BankAccountSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $companyId,
        public readonly string $name,
        public readonly string $bankName,
        public readonly string $bankAccountNumber,
        public readonly string $currency,
    ){}
}
