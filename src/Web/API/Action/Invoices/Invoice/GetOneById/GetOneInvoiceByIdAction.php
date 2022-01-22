<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\GetOneById;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Invoice\GetOneById\GetInvoiceByIdQuery;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Response;

final class GetOneInvoiceByIdAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetOneInvoiceByIdRequest $request): Response
    {
        $invoice = $this->bus->handle(new GetInvoiceByIdQuery($request->id));

        return GetOneInvoiceByIdResponse::respond($invoice);
    }
}
