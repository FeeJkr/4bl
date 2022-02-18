<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem\Delete;

use App\Common\Application\Command\Command;

final class DeletePeriodItemCommand implements Command
{
    public function __construct(
        public readonly string $id,
    ){}
}
