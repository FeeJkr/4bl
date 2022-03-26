<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet;

final class WalletDTOCollection
{
    private array $wallets;

    public function __construct(WalletDTO ...$wallets)
    {
        $this->wallets = $wallets;
    }

    public function add(WalletDTO $wallet): void
    {
        $this->wallets[] = $wallet;
    }

    public function toArray(): array
    {
        return $this->wallets;
    }
}
