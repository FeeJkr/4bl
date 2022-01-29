<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Company\CompanyDTO;
use App\Modules\Invoices\Application\Company\CompanyRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class GetOneCompanyByIdHandler implements QueryHandler
{
    public function __construct(private CompanyRepository $repository, private UserContext $userContext){}

    public function __invoke(GetOneCompanyByIdQuery $query): CompanyDTO
    {
        return $this->repository->getById($query->id, $this->userContext->getUserId()->toString());
    }
}
