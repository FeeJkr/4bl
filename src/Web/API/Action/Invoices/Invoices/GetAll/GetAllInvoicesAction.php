<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Invoice\GetAll\GetAllInvoicesQuery;
use App\Web\API\Action\AbstractAction;

class GetAllInvoicesAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(): GetAllInvoicesResponse
    {
        return GetAllInvoicesResponse::respond(
            $this->bus->handle(new GetAllInvoicesQuery())
        );
    }
}