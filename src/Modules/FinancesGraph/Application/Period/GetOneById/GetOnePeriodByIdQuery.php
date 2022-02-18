<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\GetOneById;

use App\Common\Application\Query\Query;

final class GetOnePeriodByIdQuery implements Query
{
    public function __construct(
        public readonly string $id,
    ){}
}
