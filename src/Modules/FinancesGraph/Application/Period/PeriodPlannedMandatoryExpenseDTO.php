<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period;

use DateTimeImmutable;

final class PeriodPlannedMandatoryExpenseDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $periodId,
        public readonly DateTimeImmutable $date,
        public readonly float $amount,
    ){}
}
