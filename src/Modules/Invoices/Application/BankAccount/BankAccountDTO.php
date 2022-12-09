<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\BankAccount;

use JetBrains\PhpStorm\Pure;

final class BankAccountDTO
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

    #[Pure]
    public static function fromStorage(array $storage): self
    {
        return new BankAccountDTO(
            $storage['id'],
            $storage['users_id'],
            $storage['companies_id'],
            $storage['name'],
            $storage['bank_name'],
            $storage['bank_account_number'],
            $storage['currency_code'],
        );
    }
}
