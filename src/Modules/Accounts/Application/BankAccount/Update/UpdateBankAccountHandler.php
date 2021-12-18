<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\BankAccount\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Domain\BankAccount\BankAccountId;
use App\Modules\Accounts\Domain\BankAccount\BankAccountRepository;
use App\Modules\Accounts\Domain\BankAccount\Currency;

final class UpdateBankAccountHandler implements CommandHandler
{
    public function __construct(private BankAccountRepository $repository){}

    public function __invoke(UpdateBankAccountCommand $command): void
    {
        $bankAccount = $this->repository->findById(BankAccountId::fromString($command->id));

        $bankAccount->update(
            $command->name,
            $command->bankName,
            $command->accountNumber,
            Currency::from(mb_strtolower($command->currency)),
        );
    }
}
