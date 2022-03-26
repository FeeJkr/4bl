<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period\Category;

final class CategorySnapshot
{
    public function __construct(
        public readonly string $id,
        public readonly string $periodId,
        public readonly string $name,
        public readonly float $balance,
        public readonly bool $isMandatory,
    ){}
}
