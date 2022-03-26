<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemDTO;
use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemRepository;

final class GetOnePeriodItemByIdHandler implements QueryHandler
{
    public function __construct(private PeriodItemRepository $repository){}

    public function __invoke(GetOnePeriodItemByIdQuery $query): PeriodItemDTO
    {
        return $this->repository->fetchOneById($query->id);
    }
}
