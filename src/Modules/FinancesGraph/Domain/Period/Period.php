<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period;

use App\Common\Domain\Entity;
use App\Modules\FinancesGraph\Domain\User\UserId;
use DateTimeImmutable;

final class Period extends Entity
{
    public function __construct(
        private PeriodId $id,
        private UserId $userId,
        private string $name,
        private DateTimeImmutable $startAt,
        private DateTimeImmutable $endAt,
        private float $startBalance,
        private array $plannedMandatoryExpenses,
    ){}

    public function update(
        string $name,
        DateTimeImmutable $startAt,
        DateTimeImmutable $endAt,
        float $startBalance,
        array $plannedMandatoryExpenses,
    ): void {
        $this->name = $name;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
        $this->startBalance = $startBalance;
        $this->plannedMandatoryExpenses = $plannedMandatoryExpenses;
    }

    public function snapshot(): PeriodSnapshot
    {
        return new PeriodSnapshot(
            $this->id->toString(),
            $this->userId->toString(),
            $this->name,
            $this->startAt,
            $this->endAt,
            $this->startBalance,
            array_map(
                static fn (PlannedMandatoryExpense $expense) => $expense->snapshot(),
                $this->plannedMandatoryExpenses
            ),
        );
    }
}
