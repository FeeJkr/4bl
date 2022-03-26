<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\GetAll;

use App\Modules\FinancesGraph\Application\Period\PeriodDTO;
use App\Modules\FinancesGraph\Application\Period\PeriodPlannedMandatoryExpenseDTO;
use App\Modules\FinancesGraph\Application\Period\PeriodsCollection;
use App\Web\API\Action\Response;

final class GetAllPeriodsResponse extends Response
{
    private const DATE_FORMAT = 'd-m-Y';

    public static function respond(PeriodsCollection $collection): self
    {
        return new self(
            array_map(
                static fn(PeriodDTO $period) => [
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
                ],
                $collection->items
            )
        );
    }
}
