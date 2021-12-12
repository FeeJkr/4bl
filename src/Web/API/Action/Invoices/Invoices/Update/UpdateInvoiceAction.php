<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\Update;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Invoice\Update\UpdateInvoiceCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class UpdateInvoiceAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(UpdateInvoiceRequest $request): NoContentResponse
    {
		$command = new UpdateInvoiceCommand(
		    $request->id,
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
