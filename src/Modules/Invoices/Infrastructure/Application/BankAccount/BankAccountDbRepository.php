<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Application\BankAccount;

use App\Modules\Invoices\Application\BankAccount\BankAccountDTO;
use App\Modules\Invoices\Application\BankAccount\BankAccountRepository;
use App\Modules\Invoices\Application\BankAccount\BankAccountsCollection;
use App\Modules\Invoices\Infrastructure\Persistence\QueryBuilder\BankAccount\BankAccountQueryBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class BankAccountDbRepository implements BankAccountRepository
{
    public function __construct(private readonly Connection $connection){}

    /**
     * @throws Exception
     */
    public function getAll(string $companyId, string $userId): BankAccountsCollection
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $rows = BankAccountQueryBuilder::buildSelectWithCompanyId($queryBuilder, $userId, $companyId)
            ->fetchAllAssociative();

        return new BankAccountsCollection(
            ...array_map(static fn (array $row) => BankAccountDTO::fromStorage($row), $rows)
        );
    }

    /**
     * @throws Exception
     */
    public function getById(string $id, string $userId): BankAccountDTO
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $row = BankAccountQueryBuilder::buildSelectWithId($queryBuilder, $userId, $id)->fetchAssociative();

        return BankAccountDTO::fromStorage($row);
    }
}
