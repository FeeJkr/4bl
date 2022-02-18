<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period\PeriodItem;

final class PeriodItemCategorySnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $periodItemId,
        public readonly string $categoryId,
        public readonly float $amount,
    ){}
}
