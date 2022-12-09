<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Application\Contractor;

use App\Modules\Invoices\Application\Contractor\ContractorDTO;
use App\Modules\Invoices\Application\Contractor\ContractorRepository;
use App\Modules\Invoices\Application\Contractor\ContractorsCollection;
use App\Modules\Invoices\Infrastructure\Persistence\QueryBuilder\Contractor\ContractorQueryBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class ContractorDbRepository implements ContractorRepository
{
    public function __construct(private readonly Connection $connection){}

    /**
     * @throws Exception
     */
    public function getAll(string $userId): ContractorsCollection
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $rows = ContractorQueryBuilder::buildSelect($queryBuilder, $userId)->fetchAllAssociative();

        return new ContractorsCollection(
            ...array_map(static fn(array $storage) => ContractorDTO::fromStorage($storage), $rows)
        );
    }

    /**
     * @throws Exception
     */
    public function getById(string $id, string $userId): ContractorDTO
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $row = ContractorQueryBuilder::buildSelectWithId($queryBuilder, $userId, $id)->fetchAssociative();

        return ContractorDTO::fromStorage($row);
    }
}