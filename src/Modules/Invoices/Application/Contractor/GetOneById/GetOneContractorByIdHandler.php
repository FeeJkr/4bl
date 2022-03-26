<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Contractor\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Contractor\ContractorDTO;
use App\Modules\Invoices\Application\Contractor\ContractorRepository;
use App\Modules\Invoices\Domain\User\UserContext;

final class GetOneContractorByIdHandler implements QueryHandler
{
    public function __construct(private ContractorRepository $repository, private UserContext $userContext){}

    public function __invoke(GetOneContractorByIdQuery $query): ContractorDTO
    {
        return $this->repository->getById($query->id, $this->userContext->getUserId()->toString());
    }
}
