<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\BankAccount\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\BankAccount\BankAccountRepository;
use App\Modules\Invoices\Application\BankAccount\BankAccountsCollection;
use App\Modules\Invoices\Domain\User\UserContext;

final class GetAllBankAccountsHandler implements QueryHandler
{
    public function __construct(private BankAccountRepository $repository, private UserContext $userContext){}

    public function __invoke(GetAllBankAccountsQuery $query): BankAccountsCollection
    {
        return $this->repository->getAll($this->userContext->getUserId()->toString());
    }
}
