<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\BankAccount\Create;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\BankAccount\Create\CreateBankAccountCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\CreatedResponse;
use App\Web\API\Action\Response;

final class CreateBankAccountAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(CreateBankAccountRequest $request): Response
    {
        $id = $this->bus->dispatch(
            new CreateBankAccountCommand(
                $request->name,
                $request->bankName,
                $request->bankAccountNumber,
                $request->currency,
            )
        );

        return CreatedResponse::respond($id);
    }
}
