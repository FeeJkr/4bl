<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Edit;

use App\Common\Application\Command\Command;

final class EditWalletCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $startBalance,
        public readonly string $currency,
    ){}
}
