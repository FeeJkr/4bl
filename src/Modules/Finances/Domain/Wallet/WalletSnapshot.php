<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Wallet;

final class WalletSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $name,
        public readonly int $startBalance,
        public readonly string $currency
    ){}
}

