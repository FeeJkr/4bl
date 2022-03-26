<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\Category\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\FinancesGraph\Application\Period\Category\GetAll\GetAllCategoriesQuery;
use App\Web\API\Action\AbstractAction;

final class GetAllPeriodCategoriesAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetAllPeriodCategoriesRequest $request): GetAllPeriodCategoriesResponse
    {
        return GetAllPeriodCategoriesResponse::respond(
            $this->bus->handle(
                new GetAllCategoriesQuery($request->periodId)
            )
        );
    }
}
