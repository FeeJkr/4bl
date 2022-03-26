<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Contractor\ContractorRepository;
use App\Modules\Invoices\Application\Contractor\ContractorsCollection;
use App\Modules\Invoices\Domain\User\UserContext;

final class GetAllContractorsHandler implements QueryHandler
{
    public function __construct(private ContractorRepository $repository, private UserContext $userContext){}

    public function __invoke(GetAllContractorsQuery $query): ContractorsCollection
    {
        return $this->repository->getAll($this->userContext->getUserId()->toString());
    }
}
