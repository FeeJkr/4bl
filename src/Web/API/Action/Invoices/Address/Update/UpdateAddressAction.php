<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Address\Update;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Address\Update\UpdateAddressCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use App\Web\API\Action\Response;

final class UpdateAddressAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(UpdateAddressRequest $request): Response
    {
        $this->bus->dispatch(
            new UpdateAddressCommand(
                $request->id,
                $request->name,
                $request->street,
                $request->zipCode,
                $request->city,
            )
        );

        return NoContentResponse::respond();
    }
}
