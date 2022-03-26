<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category;

interface CategoryRepository
{
    public function fetchAll(string $periodId): CategoriesCollection;
    public function fetchOneById(string $id): CategoryDTO;
}
