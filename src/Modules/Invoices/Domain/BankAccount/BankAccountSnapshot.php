<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\BankAccount;

final class BankAccountSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $companyId,
        public readonly string $name,
        public readonly string $bankName,
        public readonly string $bankAccountNumber,
        public readonly string $currency,
    ){}
}
