<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period;

use DateTimeImmutable;

final class PlannedMandatoryExpenseSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $periodId,
        public readonly DateTimeImmutable $date,
        public readonly float $amount,
    ){}
}
