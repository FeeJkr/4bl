<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Infrastructure\Domain\Period\PeriodItem;

use App\Modules\FinancesGraph\Domain\Period\Category\CategoryId;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemCategory;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemCategoryId;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemCategorySnapshot;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemId;
use App\Modules\FinancesGraph\Infrastructure\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class PeriodItemCategoryDbRepository
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function fetchByPeriodItemId(string $periodItemId): array
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->select(
                'fgpic.id',
                'fgpic.finances_graphs_period_items_id',
                'fgpic.finances_graphs_period_categories_id',
                'fgpic.amount',
            )
            ->from('finances_graphs_periods_item_categories', 'fgpic')
            ->join('fgpic', 'finances_graphs_period_items', 'fgpi', 'fgpi.id = fgpic.finances_graphs_period_items_id')
            ->join('fgpi', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpi.finances_graphs_periods_id')
            ->where('fgpic.finances_graphs_period_items_id = :periodItemId')
            ->andWhere('fgp.users_id = :userId')
            ->setParameters([
                'periodItemId' => $periodItemId,
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAllAssociative();

        return array_map(
            static fn (array $row) => new PeriodItemCategory(
                PeriodItemId::fromString($row['finances_graphs_period_items_id']),
                CategoryId::fromString($row['finances_graphs_period_categories_id']),
                (float) $row['amount'],
            ),
            $rows,
        );
    }

    /**
     * @throws Exception
     */
    public function deleteByPeriodItemId(string $periodItemId): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('finances_graphs_periods_item_categories', 'fgpic')
            ->join('fgpic', 'finances_graphs_period_items', 'fgpi', 'fgpi.id = fgpic.finances_graphs_period_id')
            ->join('fgpi', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpi.finances_graphs_periods_id')
            ->where('fgpic.finances_graphs_period_items_id = :periodItemId')
            ->andWhere('fgp.users_id = :userId')
            ->setParameters([
                'periodItemId' => $periodItemId,
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function store(PeriodItemCategorySnapshot $periodItemCategory): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('finances_graphs_periods_item_categories')
            ->values([
                'id' => ':id',
                'finances_graphs_period_items_id' => ':periodItemId',
                'finances_graphs_period_categories_id' => ':categoryId',
                'amount' => ':amount'
            ])
            ->setParameters([
                'id' => $periodItemCategory->id,
                'periodItemId' => $periodItemCategory->periodItemId,
                'categoryId' => $periodItemCategory->periodItemId,
                'amount' => $periodItemCategory->amount,
            ])
            ->executeStatement();
    }
}
