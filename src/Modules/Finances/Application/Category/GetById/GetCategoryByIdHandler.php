<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Finances\Application\Category\CategoryDTO;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetCategoryByIdHandler implements QueryHandler
{
    public function __construct(private Connection $connection){}

    /**
     * @throws Exception
     */
    public function __invoke(GetCategoryByIdQuery $query): CategoryDTO
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(['id', 'name', 'type', 'icon'])
            ->from('categories')
            ->where('id = :id')
            ->setParameter('id', $query->id)
            ->executeQuery()
            ->fetchAssociative();

        return CategoryDTO::createFromRow($row);
    }
}
