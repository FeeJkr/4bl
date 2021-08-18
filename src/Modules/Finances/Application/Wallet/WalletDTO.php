<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet;

use JetBrains\PhpStorm\Pure;

final class WalletDTO
{
    public function __construct(
        private string $id,
        private string $userId,
        private string $name,
        private int $startBalance,
        private string $currency,
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