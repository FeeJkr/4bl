<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\BankAccount;

use JetBrains\PhpStorm\Pure;

final class BankAccountDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $name,
        public readonly string $bankName,
        public readonly string $accountNumber,
        public readonly string $currency,
    ){}

    #[Pure]
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['user_id'],
            $data['name'],
            $data['bank_name'],
            $data['account_number'],
            $data['currency'],
        );
    }
}
