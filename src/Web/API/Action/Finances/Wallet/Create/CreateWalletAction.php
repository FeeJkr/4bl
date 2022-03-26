<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\Create;

use App\Common\Application\Command\CommandBus;
use App\Modules\Finances\Application\Wallet\Create\CreateWalletCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class CreateWalletAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(CreateWalletRequest $request): NoContentResponse
    {
        $command = new CreateWalletCommand(
            $request->name,
            $request->startBalance,
            $request->currency,
        );

        $this->bus->dispatch($command);

        return NoContentResponse::respond();
    }
}
