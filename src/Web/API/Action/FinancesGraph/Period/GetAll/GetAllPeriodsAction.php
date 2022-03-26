<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\FinancesGraph\Application\Period\GetAll\GetAllPeriodsQuery;
use App\Web\API\Action\AbstractAction;

final class GetAllPeriodsAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(): GetAllPeriodsResponse
    {
        return GetAllPeriodsResponse::respond(
            $this->bus->handle(new GetAllPeriodsQuery())
        );
    }
}
