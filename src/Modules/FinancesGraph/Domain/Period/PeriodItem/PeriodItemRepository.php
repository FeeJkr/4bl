<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period\PeriodItem;

use App\Modules\FinancesGraph\Domain\Period\PeriodId;

interface PeriodItemRepository
{
    public function fetchById(PeriodItemId $id): PeriodItem;
    public function store(PeriodItemSnapshot $periodItem): void;
    public function delete(PeriodItemId $id): void;
    public function save(PeriodItemSnapshot $periodItem): void;
}
