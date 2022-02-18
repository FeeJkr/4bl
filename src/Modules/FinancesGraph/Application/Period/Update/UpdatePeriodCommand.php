<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Update;

use App\Common\Application\Command\Command;

final class UpdatePeriodCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $startAt,
        public readonly string $endAt,
        public readonly float $startBalance,
        public readonly array $plannedMandatoryExpenses,
        public readonly array $categories,
    ){}
}