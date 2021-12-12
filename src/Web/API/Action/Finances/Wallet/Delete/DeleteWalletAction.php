<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\Delete;

use App\Common\Application\Command\CommandBus;
use App\Modules\Finances\Application\Wallet\Delete\DeleteWalletCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class DeleteWalletAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(DeleteWalletRequest $request): NoContentResponse
    {
        $command = new DeleteWalletCommand($request->id);

        $this->bus->dispatch($command);

        return NoContentResponse::respond();
    }
}
