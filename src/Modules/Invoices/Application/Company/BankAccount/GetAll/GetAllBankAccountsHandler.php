<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\BankAccount\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Company\BankAccount\BankAccountDTO;
use App\Modules\Invoices\Application\Company\BankAccount\BankAccountsCollection;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetAllBankAccountsHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function __invoke(GetAllBankAccountsQuery $query): BankAccountsCollection
    {
        $bankAccounts = $this->connection
            ->createQueryBuilder()
            ->select(
                'icba.id',
                'icba.invoices_companies_id',
                'icba.name',
                'icba.bank_name',
                'icba.bank_account_number',
                'icba.currency',
            )
            ->from('invoices_companies_bank_accounts', 'icba')
            ->join('icba', 'invoices_companies', 'ic', 'ic.id = icba.invoices_companies_id')
            ->where('ic.users_id = :userId')
            ->setParameter('userId', $this->userContext->getUserId()->toString())
            ->fetchAllAssociative();

        return new BankAccountsCollection(
            ...array_map(static fn(array $storage) => BankAccountDTO::fromStorage($storage), $bankAccounts)
        );
    }
}
