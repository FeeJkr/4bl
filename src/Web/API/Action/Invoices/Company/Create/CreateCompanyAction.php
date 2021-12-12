<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Create;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Company\Create\CreateCompanyCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class CreateCompanyAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(CreateCompanyRequest $request): NoContentResponse
    {
		$command = new CreateCompanyCommand(
			$request->street,
			$request->zipCode,
			$request->city,
			$request->name,
			$request->identificationNumber,
			$request->email,
			$request->phoneNumber
		);

		$this->bus->dispatch($command);

		return NoContentResponse::respond();
    }
}
