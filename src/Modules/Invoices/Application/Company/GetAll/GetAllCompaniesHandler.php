<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Company\CompaniesCollection;
use App\Modules\Invoices\Application\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class GetAllCompaniesHandler implements QueryHandler
{
    public function __construct(private CompanyRepository $repository, private UserContext $userContext){}

    public function __invoke(GetAllCompaniesQuery $query): CompaniesCollection
    {
        return $this->repository->getAll($this->userContext->getUserId()->toString());
    }
}
