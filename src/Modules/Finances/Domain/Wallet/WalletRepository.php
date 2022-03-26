<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Wallet;

use App\Modules\Finances\Domain\User\UserId;

interface WalletRepository
{
    public function store(Wallet $wallet): void;
    public function delete(WalletId $id, UserId $userId): void;
    public function getById(WalletId $id, UserId $userId): Wallet;
    public function save(Wallet $wallet): void;
}
