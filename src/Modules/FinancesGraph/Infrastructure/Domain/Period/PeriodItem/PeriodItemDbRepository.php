<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Infrastructure\Domain\Period\PeriodItem;

use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItem;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemId;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemRepository;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemSnapshot;
use App\Modules\FinancesGraph\Infrastructure\Domain\User\UserContext;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class PeriodItemDbRepository implements PeriodItemRepository
{
    public function __construct(
        private Connection $connection,
        private UserContext $userContext,
        private PeriodItemCategoryDbRepository $periodItemCategoryRepository,
    ){}

    /**
     * @throws Exception
     */
    public function fetchById(PeriodItemId $id): PeriodItem
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'fgpi.id',
                'fgpi.finances_graphs_periods_id',
                'fgpi.date',
            )
            ->from('finances_graphs_period_items', 'fgpi')
            ->join('fgpi', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpi.finances_graphs_periods_id')
            ->where('fgpi.id = :id')
            ->andWhere('fgp.users_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAllAssociative();

        $items = $this->periodItemCategoryRepository->fetchByPeriodItemId($row['id']);

        return new PeriodItem(
            PeriodItemId::fromString($row['id']),
            PeriodId::fromString($row['finances_graphs_periods_id']),
            DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $row['date']),
            $items,
        );
    }

    /**
     * @throws Exception
     */
    public function store(PeriodItemSnapshot $periodItem): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('finances_graphs_period_items')
            ->values([
                'id' => ':id',
                'finances_graphs_periods_id' => ':periodId',
                'date' => ':date',
            ])
            ->setParameters([
                'id' => $periodItem->id,
                'periodId' => $periodItem->periodId,
                'date' => $periodItem->date->format('Y-m-d 00:00:00'),
            ])
            ->executeStatement();

        foreach ($periodItem->items as $item) {
            $this->periodItemCategoryRepository->store($item);
        }
    }

    /**
     * @throws Exception
     */
    public function delete(PeriodItemId $id): void
    {
        $this->periodItemCategoryRepository->deleteByPeriodItemId($id->toString());

        $this->connection
            ->createQueryBuilder()
            ->delete('finances_graphs_period_items', 'fgpi')
            ->join('fgpi', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpi.finances_graphs_periods_id')
            ->where('fgpi.id = :id')
            ->andWhere('fgp.users_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function save(PeriodItemSnapshot $periodItem): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update('finances_graphs_period_items', 'fgpi')
            ->set('fgpi.date', ':date')
            ->join('fgpi', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpi.finances_graphs_periods_id')
            ->where('fgpi.id = :id')
            ->andWhere('fgpi.finances_graphs_periods_id = :periodId')
            ->andWhere('fgp.users_id = :userId')
            ->setParameters([
                'id' => $periodItem->id,
                'periodId' => $periodItem->periodId,
                'userId' => $this->userContext->getUserId()->toString(),
                'date' => $periodItem->date->format('Y-m-d 00:00:00'),
            ])
            ->executeStatement();

        $this->periodItemCategoryRepository->deleteByPeriodItemId($periodItem->id);

        foreach ($periodItem->items as $item) {
            $this->periodItemCategoryRepository->store($item);
        }
    }
}
