<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Address\Address;
use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\Contractor\Contractor;
use App\Modules\Invoices\Domain\Contractor\ContractorRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class CreateContractorHandler implements CommandHandler
{
    public function __construct(private ContractorRepository $repository, private UserContext $userContext){}

    public function __invoke(CreateContractorCommand $command): string
    {
        $contractor = Contractor::createNew(
            $this->userContext->getUserId(),
            $command->name,
            $command->identificationNumber,
            $command->street,
            $command->city,
            $command->zipCode,
        );

        $this->repository->store($contractor->snapshot());

        return $contractor->snapshot()->id;
    }
}
