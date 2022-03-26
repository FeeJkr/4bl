<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\Update;

use App\Common\Application\Command\CommandBus;
use App\Modules\FinancesGraph\Application\Period\Update\UpdatePeriodCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class UpdatePeriodAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(UpdatePeriodRequest $request): NoContentResponse
    {
        $this->bus->dispatch(
            new UpdatePeriodCommand(
                $request->id,
                $request->name,
                $request->startAt,
                $request->endAt,
                $request->startBalance,
                $request->plannedMandatoryExpenses,
                $request->categories,
            )
        );

        return NoContentResponse::respond();
    }
}
