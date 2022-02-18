<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period;

use App\Modules\FinancesGraph\Domain\User\UserId;

interface PeriodRepository
{
    public function fetchById(PeriodId $id, UserId $userId): Period;
    public function store(PeriodSnapshot $period): void;
    public function delete(PeriodId $id, UserId $userId): void;
    public function save(PeriodSnapshot $period): void;
}