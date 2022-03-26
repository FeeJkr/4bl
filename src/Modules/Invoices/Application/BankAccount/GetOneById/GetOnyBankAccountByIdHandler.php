<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\BankAccount\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\BankAccount\BankAccountDTO;
use App\Modules\Invoices\Application\BankAccount\BankAccountRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class GetOnyBankAccountByIdHandler implements QueryHandler
{
    public function __construct(
        private BankAccountRepository $repository,
        private UserContext $userContext,
    ){}

    public function __invoke(GetOneBankAccountByIdQuery $query): BankAccountDTO
    {
        return $this->repository->getById($query->id, $this->userContext->getUserId()->toString());
    }
}
