<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Application\Company;

use App\Modules\Invoices\Application\Company\CompaniesCollection;
use App\Modules\Invoices\Application\Company\CompanyDTO;
use App\Modules\Invoices\Application\Company\CompanyRepository;
use App\Modules\Invoices\Infrastructure\Persistence\QueryBuilder\Company\CompanyQueryBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class CompanyDbRepository implements CompanyRepository
{
    public function __construct(private readonly Connection $connection){}

    /**
     * @throws Exception
     */
    public function getAll(string $userId): CompaniesCollection
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $rows = CompanyQueryBuilder::buildSelect($queryBuilder, $userId)->fetchAllAssociative();

        return new CompaniesCollection(
            ...array_map(static fn (array $row) => CompanyDTO::fromStorage($row), $rows)
        );
    }

    /**
     * @throws Exception
     */
    public function getById(string $id, string $userId): CompanyDTO
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $row = CompanyQueryBuilder::buildSelectWithId($queryBuilder, $userId, $id)->fetchAssociative();

        return CompanyDTO::fromStorage($row);
    }
}
