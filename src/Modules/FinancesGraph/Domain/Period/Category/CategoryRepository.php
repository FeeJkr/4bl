<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period\Category;

use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use App\Modules\FinancesGraph\Domain\User\UserId;

interface CategoryRepository
{
    public function fetchById(CategoryId $id): Category;
    public function store(CategorySnapshot $category): void;
    public function delete(CategoryId $id): void;
    public function save(CategorySnapshot $category): void;
}
