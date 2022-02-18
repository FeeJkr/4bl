<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\GetOneById;

use App\Common\Application\Query\QueryBus;
use App\Modules\FinancesGraph\Application\Period\GetOneById\GetOnePeriodByIdQuery;
use App\Web\API\Action\AbstractAction;

final class GetPeriodByIdAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetPeriodByIdRequest $request): GetPeriodByIdResponse
    {
        return GetPeriodByIdResponse::respond(
            $this->bus->handle(new GetOnePeriodByIdQuery($request->id))
        );
    }
}
