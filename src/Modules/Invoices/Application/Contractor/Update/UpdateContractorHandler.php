<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Contractor\ContractorId;
use App\Modules\Invoices\Domain\Contractor\ContractorRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class UpdateContractorHandler implements CommandHandler
{
    public function __construct(private ContractorRepository $repository, private UserContext $userContext){}

    public function __invoke(UpdateContractorCommand $command): void
    {
        $contractor = $this->repository->fetchById(
            ContractorId::fromString($command->id),
            $this->userContext->getUserId(),
        );

        $contractor->update(
            $command->name,
            $command->identificationNumber,
            $command->street,
            $command->city,
            $command->zipCode
        );

        $this->repository->save($contractor->snapshot());
    }
}
