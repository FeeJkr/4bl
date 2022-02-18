<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Infrastructure\Domain\Period\Category;

use App\Modules\FinancesGraph\Domain\Period\Category\Category;
use App\Modules\FinancesGraph\Domain\Period\Category\CategoryId;
use App\Modules\FinancesGraph\Domain\Period\Category\CategoryRepository;
use App\Modules\FinancesGraph\Domain\Period\Category\CategorySnapshot;
use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use App\Modules\FinancesGraph\Domain\User\UserContext;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class CategoryDbRepository implements CategoryRepository
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function fetchById(CategoryId $id): Category
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
                'id' => $id->toString(),
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAssociative();

        return new Category(
            CategoryId::fromString($row['id']),
            PeriodId::fromString($row['finances_graphs_periods_id']),
            $row['name'],
            (float) $row['balance'],
            (bool) $row['is_mandatory'],
        );
    }

    /**
     * @throws Exception
     */
    public function store(CategorySnapshot $category): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('finances_graphs_period_categories')
            ->values([
                'id' => ':id',
                'finances_graphs_periods_id' => ':periodId',
                'name' => ':name',
                'balance' => ':balance',
                'is_mandatory' => ':isMandatory',
            ])
            ->setParameters([
                'id' => $category->id,
                'periodId' => $category->periodId,
                'name' => $category->name,
                'balance' => $category->balance,
                'isMandatory' => (int) $category->isMandatory,
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function delete(CategoryId $id): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('finances_graphs_period_categories', 'fgpc')
            ->join('fgpc', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpc.finances_graphs_periods_id')
            ->where('fgpc.id = :id')
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
    public function save(CategorySnapshot $category): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update('finances_graphs_period_categories', 'fgpc')
            ->set('fgpc.name', ':name')
            ->set('fgpc.balance', ':balance')
            ->set('fgpc.is_mandatory', ':isMandatory')
            ->set('fgpc.updated_at', ':updatedAt')
            ->join('fgpc', 'finances_graphs_periods', 'fgp', 'fgp.id = fgpc.finances_graphs_periods_id')
            ->where('fgpc.id = :id')
            ->andWhere('fgp.users_id = :userId')
            ->setParameters([
                'id' => $category->id,
                'userId' => $this->userContext->getUserId()->toString(),
                'name' => $category->name,
                'balance' => $category->balance,
                'isMandatory' => $category->isMandatory ? 1 : 0,
                'updatedAt' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ])
            ->executeStatement();
    }
}
