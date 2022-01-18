<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Address\Delete;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Address\Delete\DeleteAddressCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use App\Web\API\Action\Response;

final class DeleteAddressAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(DeleteAddressRequest $request): Response
    {
        $this->bus->dispatch(
            new DeleteAddressCommand($request->id)
        );

        return NoContentResponse::respond();
    }
}
