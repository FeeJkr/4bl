<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\BankAccount\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\BankAccount\BankAccountId;
use App\Modules\Invoices\Domain\BankAccount\BankAccountRepository;
use App\Modules\Invoices\Domain\Currency;
use App\Modules\Invoices\Domain\User\UserContext;

final class UpdateBankAccountHandler implements CommandHandler
{
    public function __construct(
        private BankAccountRepository $repository,
        private UserContext $userContext,
    ){}

    public function __invoke(UpdateBankAccountCommand $command): void
    {
        $bankAccount = $this->repository->fetchById(
            BankAccountId::fromString($command->id),
            $this->userContext->getUserId()
        );

        $bankAccount->update(
            $command->name,
            $command->bankName,
            $command->bankAccountNumber,
            Currency::from(strtolower($command->currency)),
        );

        $this->repository->save($bankAccount->snapshot());
    }
}
