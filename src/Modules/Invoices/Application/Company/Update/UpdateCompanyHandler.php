<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyException;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

class UpdateCompanyHandler implements CommandHandler
{
    public function __construct(private CompanyRepository $repository, private UserContext $userContext){}

    /**
     * @throws CompanyException
     */
    public function __invoke(UpdateCompanyCommand $command): void
    {
        $company = $this->repository->fetchById(
            CompanyId::fromString($command->companyId),
            $this->userContext->getUserId()
        ) ?? throw CompanyException::notFoundById($command->companyId);

        $company->update(
            $command->street,
            $command->zipCode,
            $command->city,
            $command->name,
            $command->identificationNumber,
            $command->email,
            $command->phoneNumber,
        );

        $this->repository->save($company);
    }
}
