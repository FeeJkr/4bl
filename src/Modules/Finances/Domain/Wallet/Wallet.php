<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Wallet;

use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserId;
use JetBrains\PhpStorm\Pure;

final class Wallet
{
    public function __construct(
        private WalletId $id,
        private UserId $userId,
        private string $name,
        private Money $startBalance,
    ){}

    public static function create(UserId $userId, string $name, Money $startBalance): self
    {
        return new self(
            WalletId::generate(),
            $userId,
            $name,
            $startBalance
        );
    }

    public function update(string $name, Money $startBalance): void
    {
        $this->name = $name;
        $this->startBalance = $startBalance;
    }

    #[Pure]
    public function getSnapshot(): WalletSnapshot
    {
        return new WalletSnapshot(
            $this->id->toString(),
            $this->userId->toString(),
            $this->name,
            $this->startBalance->value,
            $this->startBalance->currency->value,
        );
    }
}
