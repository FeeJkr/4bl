<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\BankAccount\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Domain\BankAccount\BankAccountId;
use App\Modules\Accounts\Domain\BankAccount\BankAccountRepository;

final class DeleteBankAccountFromAccountHandler implements CommandHandler
{
    public function __construct(private BankAccountRepository $repository){}

    public function __invoke(DeleteBankAccountFromAccountCommand $command): void
    {
        $this->repository->delete(BankAccountId::fromString($command->id));
    }
}
