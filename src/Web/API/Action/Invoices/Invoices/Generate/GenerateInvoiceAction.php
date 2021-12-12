<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\Generate;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Invoice\Generate\GenerateInvoiceCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class GenerateInvoiceAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(GenerateInvoiceRequest $request): NoContentResponse
    {
		$command = new GenerateInvoiceCommand(
		    $request->invoiceNumber,
            $request->generateDate,
            $request->sellDate,
            $request->generatePlace,
            $request->sellerId,
            $request->buyerId,
            $request->products,
            $request->alreadyTakenPrice,
            $request->currencyCode,
            $request->vatPercentage,
		);

		$this->bus->dispatch($command);

		return NoContentResponse::respond();
    }
}
