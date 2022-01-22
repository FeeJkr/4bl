<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Update;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Company\ContactInformationDTO;
use App\Modules\Invoices\Application\Company\Update\UpdateCompanyCommand;
use App\Modules\Invoices\Application\Company\VatInformationDTO;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use App\Web\API\Action\Response;

final class UpdateCompanyAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(UpdateCompanyRequest $request): Response
    {
        $this->bus->dispatch(
            new UpdateCompanyCommand(
                $request->id,
                $request->name,
                $request->identificationNumber,
                new ContactInformationDTO(
                    $request->email,
                    $request->phoneNumber,
                ),
                new VatInformationDTO(
                    $request->isVatPayer,
                    $request->reason,
                )
            )
        );

        return NoContentResponse::respond();
    }
}
