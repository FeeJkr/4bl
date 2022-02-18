<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\FinancesGraph\Application\Period\PeriodRepository;
use App\Modules\FinancesGraph\Application\Period\PeriodsCollection;

final class GetAllPeriodsHandler implements QueryHandler
{
    public function __construct(private PeriodRepository $repository){}

    public function __invoke(GetAllPeriodsQuery $query): PeriodsCollection
    {
        return $this->repository->fetchAll();
    }
}
