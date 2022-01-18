<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\Company\BankAccount\BankAccountId;
use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\Company\VatRejectionReason;
use App\Modules\Invoices\Domain\User\UserContext;

final class CreateCompanyHandler implements CommandHandler
{
    public function __construct(private CompanyRepository $repository, private UserContext $userContext){}

    public function __invoke(CreateCompanyCommand $command): void
    {
        $company = Company::create(
            $this->userContext->getUserId(),
            AddressId::fromString($command->addressId),
            $command->name,
            $command->identificationNumber,
            $command->vatInformationDTO->isVatPayer,
            $command->vatInformationDTO->reason
                ? VatRejectionReason::from($command->vatInformationDTO->reason)
                : null,
            $command->contactInformation->email,
            $command->contactInformation->phoneNumber,
        );

        $this->repository->store($company->snapshot());
    }
}
