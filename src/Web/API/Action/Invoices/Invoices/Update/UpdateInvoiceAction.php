<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\Update;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Invoice\Update\UpdateInvoiceCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

class UpdateInvoiceAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(UpdateInvoiceRequest $request): NoContentResponse
    {
		$command = new UpdateInvoiceCommand(
		    $request->getId(),
		    $request->getInvoiceNumber(),
            $request->getGenerateDate(),
            $request->getSellDate(),
            $request->getGeneratePlace(),
            $request->getSellerId(),
            $request->getBuyerId(),
            $request->getProducts(),
            $request->getAlreadyTakenPrice(),
            $request->getCurrencyCode(),
            $request->getVatPercentage(),
		);

		$this->bus->dispatch($command);

		return NoContentResponse::respond();
    }
}