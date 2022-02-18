<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period;

final class PeriodPlannedMandatoryExpensesCollection
{
    public readonly array $items;

    public function __construct(PeriodPlannedMandatoryExpenseDTO ...$items)
    {
        $this->items = $items;
    }
}
