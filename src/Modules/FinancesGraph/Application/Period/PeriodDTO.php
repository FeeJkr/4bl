<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period;

use DateTimeImmutable;

final class PeriodDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly DateTimeImmutable $startAt,
        public readonly DateTimeImmutable $endAt,
        public readonly float $startBalance,
        public readonly PeriodPlannedMandatoryExpensesCollection $expenses,
    ){}
}
