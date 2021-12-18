<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\BankAccount\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Accounts\Application\BankAccount\BankAccountDTO;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetOneBankAccountByIdHandler implements QueryHandler
{
    public function __construct(private Connection $connection){}

    /**
     * @throws Exception
     */
    public function __invoke(GetOneBankAccountByIdQuery $query): BankAccountDTO
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select()
            ->from()
            ->where()
            ->setParameters([])
            ->executeQuery()
            ->fetchAssociative();

        return BankAccountDTO::fromArray($row);
    }
}
