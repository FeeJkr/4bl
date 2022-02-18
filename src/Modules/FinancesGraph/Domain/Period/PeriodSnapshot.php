<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period;

use DateTimeImmutable;

final class PeriodSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $name,
        public readonly DateTimeImmutable $startAt,
        public readonly DateTimeImmutable $endAt,
        public readonly float $startBalance,
        public readonly array $plannedMandatoryExpenses,
    ){}
}
