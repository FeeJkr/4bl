<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category\Create;

use App\Common\Application\Command\Command;

final class CreateCategoryCommand implements Command
{
    public function __construct(
        public readonly string $periodId,
        public readonly string $name,
        public readonly float $balance,
        public readonly bool $isMandatory,
    ){}
}
