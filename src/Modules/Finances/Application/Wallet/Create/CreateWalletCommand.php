<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Create;

use App\Common\Application\Command\Command;

final class CreateWalletCommand implements Command
{
    public function __construct(
        private string $name,
        private int $startBalance,
        private string $currency,
    ){}

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