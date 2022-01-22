<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Contractor\Create;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Contractor\Create\CreateContractorCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\CreatedResponse;
use App\Web\API\Action\Response;

final class CreateContractorAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(CreateContractorRequest $request): Response
    {
        $id = $this->bus->dispatch(
            new CreateContractorCommand(
                $request->addressId,
                $request->name,
                $request->identificationNumber,
            )
        );

        return CreatedResponse::respond($id);
    }
}
