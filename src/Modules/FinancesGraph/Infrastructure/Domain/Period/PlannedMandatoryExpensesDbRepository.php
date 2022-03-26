<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Infrastructure\Domain\Period;

use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use App\Modules\FinancesGraph\Domain\Period\PlannedMandatoryExpense;
use App\Modules\FinancesGraph\Domain\Period\PlannedMandatoryExpenseId;
use App\Modules\FinancesGraph\Domain\Period\PlannedMandatoryExpenseSnapshot;
use App\Modules\FinancesGraph\Domain\User\UserContext;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class PlannedMandatoryExpensesDbRepository
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function fetchByPeriodId(string $periodId): array
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->select(
                'fgpme.id',
                'fgpme.finances_graphs_periods_id',
                'fgpme.date',
                'fgpme.amount',
            )
            ->from('finances_graphs_planned_mandatory_expenses', 'fgpme')
            ->join('fgpme', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpme.finances_graphs_periods_id')
            ->where('fgpme.finances_graphs_periods_id = :periodId')
            ->andWhere('fgp.users_id = :userId')
            ->setParameters([
                'periodId' => $periodId,
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAllAssociative();

        return array_map(
            static fn (array $row) => new PlannedMandatoryExpense(
                PlannedMandatoryExpenseId::fromString($row['id']),
                PeriodId::fromString($row['finances_graphs_periods_id']),
                DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $row['date']),
                (float) $row['amount']
            ),
            $rows
        );
    }

    /**
     * @throws Exception
     */
    public function deleteByPeriodId(string $periodId): void
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->delete('finances_graphs_planned_mandatory_expenses', 'fgpme')
            ->join('fgpme', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpme.finances_graphs_periods_id')
            ->where('fgpme.finances_graphs_periods_id = :periodId')
            ->andWhere('fgp.users_id = :userId')
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function store(PlannedMandatoryExpenseSnapshot $expense): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('finances_graphs_planned_mandatory_expenses')
            ->values([
                'id' => ':id',
                'finances_graphs_periods_id' => ':periodId',
                'date' => ':date',
                'amount' => ':amount',
            ])
            ->setParameters([
                'id' => $expense->id,
                'periodId' => $expense->periodId,
                'date' => $expense->date->format('Y-m-d 00:00:00'),
                'amount' => $expense->amount,
            ])
            ->executeStatement();
    }
}
