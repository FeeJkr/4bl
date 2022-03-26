<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem;

final class PeriodItemCategoryDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $periodItemId,
        public readonly string $categoryId,
        public readonly float $amount,
    ){}
}
