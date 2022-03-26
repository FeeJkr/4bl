<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\Delete;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Invoice\Delete\DeleteInvoiceCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use App\Web\API\Action\Response;

final class DeleteInvoiceAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(DeleteInvoiceRequest $request): Response
    {
        $this->bus->dispatch(new DeleteInvoiceCommand($request->id));

        return NoContentResponse::respond();
    }
}
