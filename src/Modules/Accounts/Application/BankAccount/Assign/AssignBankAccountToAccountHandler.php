<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\BankAccount\Assign;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Domain\BankAccount\BankAccount;
use App\Modules\Accounts\Domain\BankAccount\BankAccountRepository;
use App\Modules\Accounts\Domain\BankAccount\Currency;

final class AssignBankAccountToAccountHandler implements CommandHandler
{
    public function __construct(private BankAccountRepository $repository){}

    public function __invoke(AssignBankAccountToAccountCommand $command): void
    {
        $bankAccount = new BankAccount(
            $this->repository->nextIdentity(),
            $command->name,
            $command->bankName,
            $command->accountNumber,
            Currency::from(mb_strtolower($command->currency)),
        );

        $this->repository->store($bankAccount);
    }
}
