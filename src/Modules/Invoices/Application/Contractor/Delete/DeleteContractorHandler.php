<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Contractor\ContractorId;
use App\Modules\Invoices\Domain\Contractor\ContractorRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class DeleteContractorHandler implements CommandHandler
{
    public function __construct(private ContractorRepository $repository, private UserContext $userContext){}

    public function __invoke(DeleteContractorCommand $command): void
    {
        $this->repository->delete(
            ContractorId::fromString($command->id),
            $this->userContext->getUserId(),
        );
    }

}
