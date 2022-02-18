<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\PeriodItem\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\FinancesGraph\Application\Period\PeriodItem\GetAll\GetAllPeriodItemsQuery;
use App\Web\API\Action\AbstractAction;

final class GetAllPeriodItemsAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetAllPeriodItemsRequest $request): GetAllPeriodItemsResponse
    {
        return GetAllPeriodItemsResponse::respond(
            $this->bus->handle(new GetAllPeriodItemsQuery($request->periodId))
        );
    }
}
