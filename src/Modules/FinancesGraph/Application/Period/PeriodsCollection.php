<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period;

final class PeriodsCollection
{
    public readonly array $items;

    public function __construct(PeriodDTO ...$items)
    {
        $this->items = $items;
    }
}
