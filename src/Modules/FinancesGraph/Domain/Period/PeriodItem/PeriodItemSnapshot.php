<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period\PeriodItem;

use DateTimeImmutable;

final class PeriodItemSnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $periodId,
        public readonly DateTimeImmutable $date,
        public readonly array $items,
    ){}
}
