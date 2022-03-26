<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category;

final class CategoriesCollection
{
    public readonly array $items;

    public function __construct(CategoryDTO ...$items)
    {
        $this->items = $items;
    }
}
