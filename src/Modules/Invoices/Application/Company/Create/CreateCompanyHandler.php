<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyAddress;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

class CreateCompanyHandler implements CommandHandler
{
    public function __construct(
        private CompanyRepository $repository,
        private UserContext $userContext
    ){}

    public function __invoke(CreateCompanyCommand $command): void
    {
        $companyAddress = CompanyAddress::create($command->getStreet(), $command->getZipCode(), $command->getCity());
        $company = Company::create(
            $this->userContext->getUserId(),
            $companyAddress,
            $command->getName(),
            $command->getIdentificationNumber(),
            $command->getEmail(),
            $command->getPhoneNumber(),
        );

        $this->repository->store($company);
    }
}