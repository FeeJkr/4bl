<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\GetOneById;

use App\Modules\FinancesGraph\Application\Period\PeriodDTO;
use App\Modules\FinancesGraph\Application\Period\PeriodPlannedMandatoryExpenseDTO;
use App\Web\API\Action\Response;

final class GetPeriodByIdResponse extends Response
{
    private const DATE_FORMAT = 'Y-m-d';

    public static function respond(PeriodDTO $period): self
    {
        return new self([
            'id' => $period->id,
            'name' => $period->name,
            'startAt' => $period->startAt->format(self::DATE_FORMAT),
            'endAt' => $period->endAt->format(self::DATE_FORMAT),
            'startBalance' => $period->startBalance,
            'expenses' => array_map(
                static fn (PeriodPlannedMandatoryExpenseDTO $expense) => [
                    'id' => $expense->id,
                    'date' => $expense->date->format(self::DATE_FORMAT),
                    'amount' => $expense->amount,
                ],
                $period->expenses->items,
            )
        ]);
    }
}
