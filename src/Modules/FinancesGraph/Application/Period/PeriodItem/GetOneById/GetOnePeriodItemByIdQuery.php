<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem\GetOneById;

use App\Common\Application\Query\Query;

final class GetOnePeriodItemByIdQuery implements Query
{
    public function __construct(
        public readonly string $id,
    ){}
}
