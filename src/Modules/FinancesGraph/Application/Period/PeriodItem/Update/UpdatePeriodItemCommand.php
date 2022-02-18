<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem\Update;

final class UpdatePeriodItemCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $date,
        public readonly array $items,
    ){}
}
