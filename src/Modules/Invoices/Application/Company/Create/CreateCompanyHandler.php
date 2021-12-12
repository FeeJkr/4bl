<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyAddress;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class CreateCompanyHandler implements CommandHandler
{
    public function __construct(private CompanyRepository $repository, private UserContext $userContext){}

    public function __invoke(CreateCompanyCommand $command): void
    {
        $companyAddress = CompanyAddress::create($command->street, $command->zipCode, $command->city);
        $company = Company::create(
            $this->userContext->getUserId(),
            $companyAddress,
            $command->name,
            $command->identificationNumber,
            $command->email,
            $command->phoneNumber,
        );

        $this->repository->store($company);
    }
}
