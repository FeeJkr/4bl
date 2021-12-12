<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Create;

use App\Common\Application\Command\Command;

final class CreateWalletCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly int $startBalance,
        public readonly string $currency,
    ){}
}
