<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\BankAccount\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\BankAccount\BankAccountId;
use App\Modules\Invoices\Domain\Company\BankAccount\BankAccountRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class DeleteBankAccountHandler implements CommandHandler
{
    public function __construct(
        private BankAccountRepository $repository,
        private UserContext $userContext,
    ){}

    public function __invoke(DeleteBankAccountCommand $command): void
    {
        $this->repository->delete(
            BankAccountId::fromString($command->id),
            $this->userContext->getUserId(),
        );
    }
}
