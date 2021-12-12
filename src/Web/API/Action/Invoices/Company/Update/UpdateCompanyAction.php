<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Update;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Company\Update\UpdateCompanyCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class UpdateCompanyAction extends AbstractAction
{
	public function __construct(private CommandBus $bus){}

	public function __invoke(UpdateCompanyRequest $request): NoContentResponse
	{
		$this->bus->dispatch(new UpdateCompanyCommand(
			$request->companyId,
			$request->street,
			$request->zipCode,
			$request->city,
			$request->name,
			$request->identificationNumber,
			$request->email,
			$request->phoneNumber,
		));

		return NoContentResponse::respond();
	}
}
