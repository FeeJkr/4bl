<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet;

use JetBrains\PhpStorm\Pure;

final class WalletDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $name,
        public readonly int $startBalance,
        public readonly string $currency,
    ){}

    #[Pure]
    public static function createFromRow(array $row): self
    {
        return new self(
            $row['id'],
            $row['user_id'],
            $row['name'],
            (int) $row['start_balance'],
            $row['currency'],
        );
    }
}
