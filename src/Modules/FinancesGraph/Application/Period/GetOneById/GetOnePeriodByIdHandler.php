<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\FinancesGraph\Application\Period\PeriodDTO;
use App\Modules\FinancesGraph\Application\Period\PeriodRepository;

final class GetOnePeriodByIdHandler implements QueryHandler
{
    public function __construct(private PeriodRepository $repository){}

    public function __invoke(GetOnePeriodByIdQuery $query): PeriodDTO
    {
        return $this->repository->fetchOneById($query->id);
    }
}
