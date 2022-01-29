<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\BankAccount\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\BankAccount\BankAccount;
use App\Modules\Invoices\Domain\BankAccount\BankAccountRepository;
use App\Modules\Invoices\Domain\Currency;
use App\Modules\Invoices\Domain\User\UserContext;

final class CreateBankAccountHandler implements CommandHandler
{
    public function __construct(
        private BankAccountRepository $bankAccountRepository,
        private UserContext $userContext
    ){}

    public function __invoke(CreateBankAccountCommand $command): string
    {
        $bankAccount = new BankAccount(
            $this->bankAccountRepository->nextIdentity(),
            $this->userContext->getUserId(),
            $command->name,
            $command->bankName,
            $command->bankAccountNumber,
            Currency::from($command->currency),
        );

        $this->bankAccountRepository->store($bankAccount->snapshot());

        return $bankAccount->snapshot()->id;
    }
}
