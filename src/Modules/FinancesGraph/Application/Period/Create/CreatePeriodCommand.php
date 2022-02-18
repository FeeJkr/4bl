<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Create;

use App\Common\Application\Command\Command;

final class CreatePeriodCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $startAt,
        public readonly string $endAt,
        public readonly float $startBalance,
        public readonly array $plannedMandatoryExpenses,
        public readonly array $categories,
    ){}
}
