<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Delete;

final class DeleteWalletCommand
{
    private int $walletId;

    public function __construct(int $walletId)
    {
        $this->walletId = $walletId;
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }
}
