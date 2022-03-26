<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Infrastructure\Application\Period\Category;

use App\Modules\FinancesGraph\Application\Period\Category\CategoriesCollection;
use App\Modules\FinancesGraph\Application\Period\Category\CategoryDTO;
use App\Modules\FinancesGraph\Application\Period\Category\CategoryRepository;
use App\Modules\FinancesGraph\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class CategoryDbRepository implements CategoryRepository
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function fetchAll(string $periodId): CategoriesCollection
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->select(
                'fgpc.id',
                'fgpc.finances_graphs_periods_id',
                'fgpc.name',
                'fgpc.balance',
                'fgpc.is_mandatory',
            )
            ->from('finances_graphs_period_categories', 'fgpc')
            ->join('fgpc', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpc.finances_graphs_periods_id')
            ->where('fgpc.finances_graphs_periods_id = :periodId')
            ->andWhere('fgp.users_id = :userId')
            ->setParameters([
                'periodId' => $periodId,
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAllAssociative();

        return new CategoriesCollection(
            ...array_map(
                static fn(array $row) => new CategoryDTO(
                    $row['id'],
                    $row['finances_graphs_periods_id'],
                    $row['name'],
                    (float) $row['balance'],
                    (bool) $row['is_mandatory'],
                ),
                $rows
            )
        );
    }

    /**
     * @throws Exception
     */
    public function fetchOneById(string $id): CategoryDTO
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'fgpc.id',
                'fgpc.finances_graphs_periods_id',
                'fgpc.name',
                'fgpc.balance',
                'fgpc.is_mandatory',
            )
            ->from('finances_graphs_period_categories', 'fgpc')
            ->join('fgpc', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpc.finances_graphs_periods_id')
            ->where('fgpc.id = :id')
            ->andWhere('fgp.users_id = :userId')
            ->setParameters([
                'id' => $id,
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAssociative();

        return new CategoryDTO(
            $row['id'],
            $row['finances_graphs_periods_id'],
            $row['name'],
            (float) $row['balance'],
            (bool) $row['is_mandatory'],
        );
    }
}
