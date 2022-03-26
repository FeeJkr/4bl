<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\BankAccount\Delete;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\BankAccount\Delete\DeleteBankAccountCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use App\Web\API\Action\Response;

final class DeleteBankAccountAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(DeleteBankAccountRequest $request): Response
    {
        $this->bus->dispatch(
            new DeleteBankAccountCommand($request->id)
        );

        return NoContentResponse::respond();
    }
}
