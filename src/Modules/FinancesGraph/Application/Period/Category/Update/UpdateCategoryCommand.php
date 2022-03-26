<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category\Update;

use App\Common\Application\Command\Command;

final class UpdateCategoryCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly float $balance,
        public readonly bool $isMandatory,
    ){}
}
