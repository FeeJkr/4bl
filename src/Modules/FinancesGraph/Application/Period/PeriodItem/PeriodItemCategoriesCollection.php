<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem;

final class PeriodItemCategoriesCollection
{
    public readonly array $items;

    public function __construct(PeriodItemCategorydTO ...$items)
    {
        $this->items = $items;
    }
}
