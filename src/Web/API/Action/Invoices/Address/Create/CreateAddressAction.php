<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Address\Create;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Address\Create\CreateAddressCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Response;

final class CreateAddressAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(CreateAddressRequest $request): Response
    {
        $id = $this->bus->dispatch(
            new CreateAddressCommand(
                $request->name,
                $request->street,
                $request->zipCode,
                $request->city,
            )
        );

        return CreateAddressResponse::respond($id);
    }
}
