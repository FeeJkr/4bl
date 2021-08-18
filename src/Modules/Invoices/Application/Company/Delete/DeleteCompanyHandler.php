<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\CompanyException;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

class DeleteCompanyHandler implements CommandHandler
{
    public function __construct(
        private CompanyRepository $repository,
        private UserContext $userContext,
    ){}

    /**
     * @throws CompanyException
     */
    public function __invoke(DeleteCompanyCommand $command): void
    {
        $companyId = CompanyId::fromString($command->getCompanyId());
        $userId = $this->userContext->getUserId();

        $company = $this->repository->fetchById($companyId, $userId)
            ?? throw CompanyException::notFoundById($command->getCompanyId());

        $this->repository->delete($company);
    }
}