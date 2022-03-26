<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Create;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Company\Create\CreateCompanyCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\CreatedResponse;
use App\Web\API\Action\Response;

final class CreateCompanyAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(CreateCompanyRequest $request): Response
    {
        $id = $this->bus->dispatch(
            new CreateCompanyCommand(
                $request->name,
                $request->identificationNumber,
                $request->email,
                $request->phoneNumber,
                $request->isVatPayer,
                $request->vatRejectionReason,
                $request->street,
                $request->city,
                $request->zipCode,
            )
        );

        return CreatedResponse::respond($id);
    }
}
