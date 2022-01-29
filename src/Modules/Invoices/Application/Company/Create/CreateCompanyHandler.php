<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\Company\VatRejectionReason;
use App\Modules\Invoices\Domain\User\UserContext;

final class CreateCompanyHandler implements CommandHandler
{
    public function __construct(
        private CompanyRepository $repository,
        private UserContext $userContext,
    ){}

    public function __invoke(CreateCompanyCommand $command): string
    {
        $company = Company::create(
            $this->userContext->getUserId(),
            $command->name,
            $command->identificationNumber,
            $command->isVatPayer,
            $command->vatRejectionReason
                ? VatRejectionReason::from($command->vatRejectionReason)
                : null,
            $command->email,
            $command->phoneNumber,
            $command->street,
            $command->city,
            $command->zipCode,
        );

        $this->repository->store($company->snapshot());

        return $company->snapshot()->id;
    }
}
