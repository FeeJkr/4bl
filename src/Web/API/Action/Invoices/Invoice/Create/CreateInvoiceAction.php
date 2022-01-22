<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\Create;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Invoice\Generate\GenerateInvoiceCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\CreatedResponse;
use App\Web\API\Action\Response;

final class CreateInvoiceAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(CreateInvoiceRequest $request): Response
    {
        $id = $this->bus->dispatch(
            new GenerateInvoiceCommand(
                $request->invoiceNumber,
                $request->generatePlace,
                $request->alreadyTakenPrice,
                $request->daysForPayment,
                $request->paymentType,
                $request->bankAccountId,
                $request->currencyCode,
                $request->contractorId,
                $request->generatedAt,
                $request->soldAt,
                $request->products,
            )
        );

        return CreatedResponse::respond($id);
    }
}
