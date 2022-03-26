<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem\Create;

use App\Common\Application\Command\Command;

final class CreatePeriodItemCommand implements Command
{
    public function __construct(
        public readonly string $periodId,
        public readonly string $date,
        public readonly array $items,
    ){}
}
