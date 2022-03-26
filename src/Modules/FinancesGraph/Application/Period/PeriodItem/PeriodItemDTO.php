<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem;

use DateTimeImmutable;

final class PeriodItemDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $periodId,
        public readonly DateTimeImmutable $date,
        public readonly PeriodItemCategoriesCollection $items,
    ){}
}