<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\Company\VatRejectionReason;
use App\Modules\Invoices\Domain\User\UserContext;

final class UpdateCompanyHandler implements CommandHandler
{
    public function __construct(private CompanyRepository $repository, private UserContext $userContext){}

    public function __invoke(UpdateCompanyCommand $command): void
    {
        $company = $this->repository->fetchById(CompanyId::fromString($command->id), $this->userContext->getUserId());

        $company->update(
            $command->name,
            $command->identificationNumber,
            $command->vatInformationDTO->isVatPayer,
            $command->vatInformationDTO->reason
                ? VatRejectionReason::from($command->vatInformationDTO->reason)
                : null,
            $command->contactInformation->phoneNumber,
            $command->contactInformation->email,
        );

        $this->repository->save($company->snapshot());
    }
}
