<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period;

interface PeriodRepository
{
    public function fetchAll(): PeriodsCollection;
    public function fetchOneById(string $id): PeriodDTO;
}
