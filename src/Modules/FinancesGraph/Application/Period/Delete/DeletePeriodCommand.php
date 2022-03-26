<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Delete;

use App\Common\Application\Command\Command;

final class DeletePeriodCommand implements Command
{
    public function __construct(
        public readonly string $id,
    ){}
}
