<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class DeleteCompanyHandler implements CommandHandler
{
    public function __construct(private CompanyRepository $repository, private UserContext $userContext){}

    public function __invoke(DeleteCompanyCommand $command): void
    {
        $this->repository->delete(
            CompanyId::fromString($command->id),
            $this->userContext->getUserId(),
        );
    }
}
