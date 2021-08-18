<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Wallet;

final class WalletSnapshot
{
    public function __construct(
        private string $id,
        private string $userId,
        private string $name,
        private int $startBalance,
        private string $currency
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStartBalance(): int
    {
        return $this->startBalance;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
