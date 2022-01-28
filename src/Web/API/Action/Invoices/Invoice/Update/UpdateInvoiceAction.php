<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\Update;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Invoice\Update\UpdateInvoiceCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use App\Web\API\Action\Response;

final class UpdateInvoiceAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(UpdateInvoiceRequest $request): Response
    {
        $this->bus->dispatch(
            new UpdateInvoiceCommand(
                $request->id,
                $request->invoiceNumber,
                $request->generatePlace,
                $request->alreadyTakenPrice,
                $request->daysForPayment,
                $request->paymentType,
                $request->bankAccountId,
                $request->currencyCode,
                $request->companyId,
                $request->contractorId,
                $request->generatedAt,
                $request->soldAt,
                $request->products,
            )
        );

        return NoContentResponse::respond();
    }
}
