<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Invoice\GetAll\GetAllInvoicesQuery;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Response;

final class GetAllInvoicesAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(): Response
    {
        $invoices = $this->bus->handle(new GetAllInvoicesQuery());

        return GetAllInvoicesResponse::respond($invoices);
    }
}
