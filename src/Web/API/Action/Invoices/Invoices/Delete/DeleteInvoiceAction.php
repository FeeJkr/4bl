<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\Delete;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Invoice\Delete\DeleteInvoiceCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class DeleteInvoiceAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(DeleteInvoiceRequest $request): NoContentResponse
    {
        $this->bus->dispatch(new DeleteInvoiceCommand($request->invoiceId));

        return NoContentResponse::respond();
    }
}
