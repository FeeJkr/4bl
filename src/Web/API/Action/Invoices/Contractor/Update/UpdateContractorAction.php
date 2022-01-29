<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Contractor\Update;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Contractor\Update\UpdateContractorCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use App\Web\API\Action\Response;

final class UpdateContractorAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(UpdateContractorRequest $request): Response
    {
        $this->bus->dispatch(
            new UpdateContractorCommand(
                $request->id,
                $request->name,
                $request->identificationNumber,
                $request->street,
                $request->city,
                $request->zipCode,
            )
        );

        return NoContentResponse::respond();
    }
}
