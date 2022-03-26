<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Contractor\Delete;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Contractor\Delete\DeleteContractorCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use App\Web\API\Action\Response;

final class DeleteContractorAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(DeleteContractorRequest $request): Response
    {
        $this->bus->dispatch(
            new DeleteContractorCommand($request->id)
        );

        return NoContentResponse::respond();
    }
}
