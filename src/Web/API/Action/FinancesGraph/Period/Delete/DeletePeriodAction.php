<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\Delete;

use App\Common\Application\Command\CommandBus;
use App\Modules\FinancesGraph\Application\Period\Delete\DeletePeriodCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class DeletePeriodAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(DeletePeriodRequest $request): NoContentResponse
    {
        $this->bus->dispatch(
            new DeletePeriodCommand($request->id)
        );

        return NoContentResponse::respond();
    }
}
