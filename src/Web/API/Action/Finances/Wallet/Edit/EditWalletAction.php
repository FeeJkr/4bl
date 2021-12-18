<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\Edit;

use App\Common\Application\Command\CommandBus;
use App\Modules\Finances\Application\Wallet\Edit\EditWalletCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class EditWalletAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(EditWalletRequest $request): NoContentResponse
    {
        $command = new EditWalletCommand(
            $request->id,
            $request->name,
            $request->startBalance,
            $request->currency,
        );

        $this->bus->dispatch($command);

        return NoContentResponse::respond();
    }
}
