<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period;

use App\Common\Domain\Entity;
use DateTimeImmutable;

final class PlannedMandatoryExpense extends Entity
{
    public function __construct(
        private PlannedMandatoryExpenseId $id,
        private PeriodId $periodId,
        private DateTimeImmutable $date,
        private float $amount,
    ){}

    public function snapshot(): PlannedMandatoryExpenseSnapshot
    {
        return new PlannedMandatoryExpenseSnapshot(
            $this->id->toString(),
            $this->periodId->toString(),
            $this->date,
            $this->amount,
        );
    }
}
