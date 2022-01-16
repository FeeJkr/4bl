<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\BankAccount\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\BankAccount\BankAccount;
use App\Modules\Invoices\Domain\Company\BankAccount\BankAccountRepository;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\Currency;
use App\Modules\Invoices\Domain\User\UserContext;

final class CreateBankAccountHandler implements CommandHandler
{
    public function __construct(
        private CompanyRepository $companyRepository,
        private BankAccountRepository $bankAccountRepository,
        private UserContext $userContext
    ){}

    public function __invoke(CreateBankAccountCommand $command): void
    {
        $company = $this->companyRepository->fetchByUserId(
            $this->userContext->getUserId()
        );

        $bankAccount = new BankAccount(
            $this->bankAccountRepository->nextIdentity(),
            CompanyId::fromString($company->snapshot()->id),
            $command->name,
            $command->bankName,
            $command->bankAccountNumber,
            Currency::from($command->currency),
        );

        $this->bankAccountRepository->store($bankAccount->snapshot());
    }
}
