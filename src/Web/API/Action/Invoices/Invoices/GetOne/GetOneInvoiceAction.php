<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\GetOne;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Invoice\GetOneById\GetInvoiceByIdQuery;
use App\Web\API\Action\AbstractAction;

final class GetOneInvoiceAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetOneInvoiceRequest $request): GetOneInvoiceResponse
    {
        return GetOneInvoiceResponse::respond(
            $this->bus->handle(new GetInvoiceByIdQuery($request->invoiceId))
        );
    }
}
