<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Infrastructure\Application\Period\PeriodItem;

use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemCategoriesCollection;
use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemCategoryDTO;
use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemDTO;
use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemRepository;
use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemsCollection;
use App\Modules\FinancesGraph\Infrastructure\Domain\User\UserContext;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class PeriodItemDbRepository implements PeriodItemRepository
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function fetchAll(string $periodId): PeriodItemsCollection
    {
        $periodItems = $this->connection
            ->createQueryBuilder()
            ->select(
                'fgpi.id',
                'fgpi.finances_graphs_periods_id',
                'fgpi.date',
            )
            ->from('finances_graphs_period_items', 'fgpi')
            ->join('fgpi', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpi.finances_graphs_periods_id')
            ->where('fgp.users_id = :userId')
            ->andWhere('fgpi.finances_graphs_periods_id = :periodId')
            ->setParameters([
                'periodId' => $periodId,
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAllAssociative();

        $periodItemsIds = array_map(static fn (array $row) => $row['id'], $periodItems);

        $itemCategories = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'finances_graphs_period_items_id',
                'finances_graphs_period_categories_id',
                'amount',
            )
            ->from('finances_graphs_periods_item_categories')
            ->where('finances_graphs_period_items_id IN (:periodItems)')
            ->setParameter('periodItems', $periodItemsIds, Connection::PARAM_STR_ARRAY)
            ->fetchAllAssociative();

        $groupedCategories = [];

        foreach ($itemCategories as $category) {
            $groupedCategories[$category['finances_graphs_period_items_id']][] = new PeriodItemCategoryDTO(
                $category['id'],
                $category['finances_graphs_period_items_id'],
                $category['finances_graphs_period_categories_id'],
                (float) $category['amount'],
            );
        }

        $rows = [];

        foreach ($periodItems as $item) {
            $item['categories'] = $groupedCategories[$item['id']] ?? [];

            $rows[] = $item;
        }

        return new PeriodItemsCollection(
            ...array_map(
                static fn (array $row) => new PeriodItemDTO(
                    $row['id'],
                    $row['finances_graphs_periods_id'],
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['date']),
                    new PeriodItemCategoriesCollection(...$row['categories']),
                ),
                $rows
            )
        );
    }

    /**
     * @throws Exception
     */
    public function fetchOneById(string $id): PeriodItemDTO
    {
        // TODO: refactor

        return new PeriodItemDTO(
            $rows[0]['item_id'],
            $rows[0]['item_period_id'],
            DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $rows[0]['item_date']),
            new PeriodItemCategoriesCollection(
                ...array_map(
                    static fn (array $row) => new PeriodItemCategoryDTO(
                        $row['item_category_id'],
                        $row['item_category_item_id'],
                        $row['item_category_category_id'],
                        (float) $row['item_category_amount']
                    ),
                    $rows
                )
            )
        );
    }
}
