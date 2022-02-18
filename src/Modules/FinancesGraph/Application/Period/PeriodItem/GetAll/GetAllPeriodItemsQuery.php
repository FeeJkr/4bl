<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem\GetAll;

use App\Common\Application\Query\Query;

final class GetAllPeriodItemsQuery implements Query
{
    public function __construct(
        public readonly string $periodId,
    ){}
}
