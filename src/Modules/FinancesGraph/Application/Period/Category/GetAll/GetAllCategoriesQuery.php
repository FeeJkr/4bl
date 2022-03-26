<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category\GetAll;

use App\Common\Application\Query\Query;

final class GetAllCategoriesQuery implements Query
{
    public function __construct(
        public readonly string $periodId,
    ){}
}
