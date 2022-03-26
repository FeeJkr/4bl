<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Contractor\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Contractor\GetAll\GetAllContractorsQuery;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Response;

final class GetAllContractorsAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(): Response
    {
        $contractors = $this->bus->handle(new GetAllContractorsQuery());

        return GetAllContractorsResponse::respond($contractors);
    }
}
