<?php

declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Category\Doctrine;

use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\Modules\Finances\Domain\User\UserId;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class CategoryDbRepository implements CategoryRepository
{
    public function __construct(private Connection $connection){}

    /**
     * @throws Exception
     */
    public function store(Category $category): void
    {
        $snapshot = $category->getSnapshot();

        $this->connection
            ->createQueryBuilder()
            ->insert('categories')
            ->values([
                'id' => ':id',
                'user_id' => ':userId',
                'name' => ':name',
                'type' => ':type',
                'icon' => ':icon',
            ])
            ->setParameters([
                'id' => $snapshot->id,
                'userId' => $snapshot->userId,
                'name' => $snapshot->name,
                'type' => $snapshot->type,
                'icon' => $snapshot->icon,
            ])
            ->executeStatement();
    }

    public function nextIdentity(): CategoryId
    {
        return CategoryId::generate();
    }

    /**
     * @throws Exception
     */
    public function getById(CategoryId $id, UserId $userId): Category
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select('id', 'user_id', 'name', 'type', 'icon')
            ->from('categories')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameter('id', $id->toString())
            ->setParameter('userId', $userId->toString())
            ->executeQuery()
            ->fetchAssociative();

        return new Category(
            CategoryId::fromString($row['id']),
            UserId::fromString($row['user_id']),
            $row['name'],
            CategoryType::from($row['type']),
            $row['icon']
        );
    }

    /**
     * @throws Exception
     */
    public function delete(Category $category): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('categories')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameter('id', $category->getSnapshot()->id)
            ->setParameter('userId', $category->getSnapshot()->userId)
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function save(Category $category): void
    {
        $snapshot = $category->getSnapshot();

        $this->connection
            ->createQueryBuilder()
            ->update('categories')
            ->set('name', ':name')
            ->set('type', ':type')
            ->set('icon', ':icon')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameters([
                'id' => $snapshot->id,
                'userId' => $snapshot->userId,
                'name' => $snapshot->name,
                'type' => $snapshot->type,
                'icon' => $snapshot->icon,
            ])
            ->executeStatement();
    }
}
