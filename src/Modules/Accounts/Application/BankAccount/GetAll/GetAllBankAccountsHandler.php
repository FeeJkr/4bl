<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\BankAccount\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Accounts\Application\BankAccount\BankAccountDTO;
use App\Modules\Accounts\Application\BankAccount\BankAccountDTOCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetAllBankAccountsHandler implements QueryHandler
{
    public function __construct(private Connection $connection){}

    /**
     * @throws Exception
     */
    public function __invoke(GetAllBankAccountsQuery $query): BankAccountDTOCollection
    {
        $bankAccounts = $this->connection
            ->createQueryBuilder()
            ->select()
            ->from()
            ->where()
            ->setParameters([])
            ->executeQuery()
            ->fetchAllAssociative();

        return new BankAccountDTOCollection(
            ...array_map(static fn(array $row) => BankAccountDTO::fromArray($row), $bankAccounts)
        );
    }
}
