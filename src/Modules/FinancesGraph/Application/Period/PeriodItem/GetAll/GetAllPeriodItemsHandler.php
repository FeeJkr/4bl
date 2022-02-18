<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemRepository;
use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemsCollection;

final class GetAllPeriodItemsHandler implements QueryHandler
{
    public function __construct(private PeriodItemRepository $repository){}

    public function __invoke(GetAllPeriodItemsQuery $query): PeriodItemsCollection
    {
        return $this->repository->fetchAll($query->periodId);
    }
}
