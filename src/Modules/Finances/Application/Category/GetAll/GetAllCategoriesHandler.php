<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Finances\Application\Category\CategoryDTO;
use App\Modules\Finances\Application\Category\CategoryDTOCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetAllCategoriesHandler implements QueryHandler
{
    public function __construct(private Connection $connection){}

    /**
     * @throws Exception
     */
    public function __invoke(GetAllCategoriesQuery $query): CategoryDTOCollection
    {
        $queryBuilder = $this->connection
            ->createQueryBuilder()
            ->select(['id', 'name', 'type', 'icon'])
            ->from('categories');

        if ($query->type !== null) {
            $queryBuilder
                ->where('type = :type')
                ->setParameter('type', $query->type);
        }

        $rows = $this->connection
            ->executeQuery($queryBuilder->getSQL(), $queryBuilder->getParameters())
            ->fetchAllAssociative();
        $collection = new CategoryDTOCollection();

        foreach ($rows as $row) {
            $collection->add(CategoryDTO::createFromRow($row));
        }

        return $collection;
    }
}
