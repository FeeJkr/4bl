<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category;

final class CategoryDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $periodId,
        public readonly string $name,
        public readonly float $startBalance,
        public readonly bool $isMandatory,
    ){}
}
