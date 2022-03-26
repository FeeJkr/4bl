<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\Create;

use App\Common\Application\Command\CommandBus;
use App\Modules\FinancesGraph\Application\Period\Create\CreatePeriodCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\CreatedResponse;

final class CreatePeriodAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(CreatePeriodRequest $request): CreatedResponse
    {
        $id = $this->bus->dispatch(
            new CreatePeriodCommand(
                $request->name,
                $request->startAt,
                $request->endAt,
                $request->startBalance,
                $request->plannedMandatoryExpenses,
                $request->categories,
            )
        );

        return CreatedResponse::respond($id);
    }
}
