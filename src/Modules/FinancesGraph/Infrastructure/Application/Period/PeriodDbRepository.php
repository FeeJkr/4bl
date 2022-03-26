<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Infrastructure\Application\Period;

use App\Modules\FinancesGraph\Application\Period\PeriodDTO;
use App\Modules\FinancesGraph\Application\Period\PeriodPlannedMandatoryExpenseDTO;
use App\Modules\FinancesGraph\Application\Period\PeriodPlannedMandatoryExpensesCollection;
use App\Modules\FinancesGraph\Application\Period\PeriodRepository;
use App\Modules\FinancesGraph\Application\Period\PeriodsCollection;
use App\Modules\FinancesGraph\Domain\User\UserContext;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class PeriodDbRepository implements PeriodRepository
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function fetchAll(): PeriodsCollection
    {
        $periods = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'users_id',
                'name',
                'start_at',
                'end_at',
                'start_balance',
            )
            ->from('finances_graphs_periods')
            ->where('users_id = :userId')
            ->setParameter('userId', $this->userContext->getUserId()->toString())
            ->fetchAllAssociative();

        $periodsIds = array_map(static fn (array $row) => $row['id'], $periods);

        $mandatoryExpenses = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'finances_graphs_periods_id',
                'date',
                'amount',
            )
            ->from('finances_graphs_planned_mandatory_expenses')
            ->where('finances_graphs_periods_id IN (:periods)')
            ->setParameter('periods', $periodsIds, Connection::PARAM_STR_ARRAY)
            ->fetchAllAssociative();

        $groupedExpenses = [];

        foreach ($mandatoryExpenses as $expense) {
            $groupedExpenses[$expense['finances_graphs_periods_id']][] = new PeriodPlannedMandatoryExpenseDTO(
                $expense['id'],
                $expense['finances_graphs_periods_id'],
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $expense['date']),
                (float) $expense['amount'],
            );
        }

        $rows = [];

        foreach ($periods as $period) {
            $period['expenses'] = $groupedExpenses[$period['id']] ?? [];

            $rows[] = $period;
        }

        return new PeriodsCollection(
            ...array_map(
                static fn(array $row) => new PeriodDTO(
                    $row['id'],
                    $row['name'],
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['start_at']),
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['end_at']),
                    (float) $row['start_balance'],
                    new PeriodPlannedMandatoryExpensesCollection(...$row['expenses']),
                ),
                $rows,
            )
        );
    }

    /**
     * @throws Exception
     */
    public function fetchOneById(string $id): PeriodDTO
    {
        $period = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'users_id',
                'name',
                'start_at',
                'end_at',
                'start_balance',
            )
            ->from('finances_graphs_periods')
            ->where('users_id = :userId')
            ->andWhere('id = :id')
            ->setParameters([
                'id' => $id,
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAssociative();

        $mandatoryExpenses = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'finances_graphs_periods_id',
                'date',
                'amount',
            )
            ->from('finances_graphs_planned_mandatory_expenses')
            ->where('finances_graphs_periods_id = :periodId')
            ->setParameter('periodId', $period['id'])
            ->fetchAllAssociative();

        foreach ($mandatoryExpenses as $expense) {
            $period['expenses'][] = new PeriodPlannedMandatoryExpenseDTO(
                $expense['id'],
                $expense['finances_graphs_periods_id'],
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $expense['date']),
                (float) $expense['amount'],
            );
        }

        return new PeriodDTO(
            $period['id'],
            $period['name'],
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $period['start_at']),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $period['end_at']),
            (float) $period['start_balance'],
            new PeriodPlannedMandatoryExpensesCollection(...$period['expenses']),
        );
    }
}
