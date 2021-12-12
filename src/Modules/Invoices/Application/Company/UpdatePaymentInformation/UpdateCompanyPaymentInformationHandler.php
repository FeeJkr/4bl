<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\UpdatePaymentInformation;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\CompanyException;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class UpdateCompanyPaymentInformationHandler implements CommandHandler
{
    public function __construct(private CompanyRepository $repository, private UserContext $userContext){}

    /**
     * @throws CompanyException
     */
    public function __invoke(UpdateCompanyPaymentInformationCommand $command): void
    {
        $company = $this->repository->fetchById(
            CompanyId::fromString($command->companyId),
            $this->userContext->getUserId()
        ) ?? throw CompanyException::notFoundById($command->companyId);

        $company->updatePaymentInformation(
            $command->paymentType,
            $command->paymentLastDate,
            $command->bank,
            $command->accountNumber,
        );

        $this->repository->save($company);
    }
}
