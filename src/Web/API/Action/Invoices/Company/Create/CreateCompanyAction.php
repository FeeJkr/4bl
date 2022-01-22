<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Create;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Company\ContactInformationDTO;
use App\Modules\Invoices\Application\Company\Create\CreateCompanyCommand;
use App\Modules\Invoices\Application\Company\VatInformationDTO;
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
                $request->addressId,
                new ContactInformationDTO($request->email, $request->phoneNumber),
                new VatInformationDTO($request->isVatPayer, $request->reason),
            )
        );

        return CreatedResponse::respond($id);
    }
}
