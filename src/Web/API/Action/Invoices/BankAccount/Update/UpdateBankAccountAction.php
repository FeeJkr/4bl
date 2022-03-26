<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\BankAccount\Update;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\BankAccount\Update\UpdateBankAccountCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use App\Web\API\Action\Response;

final class UpdateBankAccountAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(UpdateBankAccountRequest $request): Response
    {
        $this->bus->dispatch(
            new UpdateBankAccountCommand(
                $request->id,
                $request->name,
                $request->bankName,
                $request->bankAccountNumber,
                $request->currency,
            )
        );

        return NoContentResponse::respond();
    }
}
