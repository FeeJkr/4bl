<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem;

interface PeriodItemRepository
{
    public function fetchAll(string $periodId): PeriodItemsCollection;
    public function fetchOneById(string $id): PeriodItemDTO;
}
