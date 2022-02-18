<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Infrastructure\Domain\Period;

use App\Modules\FinancesGraph\Domain\Period\Period;
use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use App\Modules\FinancesGraph\Domain\Period\PeriodRepository;
use App\Modules\FinancesGraph\Domain\Period\PeriodSnapshot;
use App\Modules\FinancesGraph\Domain\Period\PlannedMandatoryExpenseSnapshot;
use App\Modules\FinancesGraph\Domain\User\UserId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class PeriodDbRepository implements PeriodRepository
{
    public function __construct(
        private Connection $connection,
        private PlannedMandatoryExpensesDbRepository $expensesRepository,
    ){}

    /**
     * @throws Exception
     */
    public function fetchById(PeriodId $id, UserId $userId): Period
    {
        $row = $this->connection
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
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $userId->toString(),
            ])
            ->fetchAssociative();

        $mandatoryExpenses = $this->expensesRepository->fetchByPeriodId($row['id']);

        return new Period(
            PeriodId::fromString($row['id']),
            UserId::fromString($row['users_id']),
            $row['name'],
            DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $row['start_at']),
            DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $row['end_at']),
            (float) $row['start_balance'],
            $mandatoryExpenses,
        );
    }

    /**
     * @throws Exception
     */
    public function store(PeriodSnapshot $period): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('finances_graphs_periods')
            ->values([
                'id' => ':id',
                'users_id' => ':userId',
                'name' => ':name',
                'start_at' => ':startAt',
                'end_at' => ':endAt',
                'start_balance' => ':startBalance',
            ])
            ->setParameters([
                'id' => $period->id,
                'userId' => $period->userId,
                'name' => $period->name,
                'startAt' => $period->startAt->format('Y-m-d 00:00:00'),
                'endAt' => $period->endAt->format('Y-m-d 00:00:00'),
                'startBalance' => $period->startBalance,
            ])
            ->executeStatement();

        foreach ($period->plannedMandatoryExpenses as $expense) {
            $this->expensesRepository->store($expense);
        }
    }

    /**
     * @throws Exception
     */
    public function delete(PeriodId $id, UserId $userId): void
    {
        $this->expensesRepository->deleteByPeriodId($id->toString());

        $this->connection
            ->createQueryBuilder()
            ->delete('finances_graphs_periods')
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $userId->toString(),
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function save(PeriodSnapshot $period): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update('finances_graphs_periods')
            ->set('name', ':name')
            ->set('start_at', ':startAt')
            ->set('end_at', ':endAt')
            ->set('start_balance', ':startBalance')
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $period->id,
                'userId' => $period->userId,
                'name' => $period->name,
                'startAt' => $period->startAt->format('Y-m-d 00:00:00'),
                'endAt' => $period->endAt->format('Y-m-d 00:00:00'),
                'startBalance' => $period->startBalance,
            ])
            ->executeStatement();

        $this->expensesRepository->deleteByPeriodId($period->id);

        foreach ($period->plannedMandatoryExpenses as $expense) {
            $this->expensesRepository->store($expense);
        }
    }
}
