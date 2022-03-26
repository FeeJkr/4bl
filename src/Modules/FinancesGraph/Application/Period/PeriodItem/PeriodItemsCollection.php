<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem;

final class PeriodItemsCollection
{
    public readonly array $items;

    public function __construct(PeriodItemDTO ...$items)
    {
        $this->items = $items;
    }
}
