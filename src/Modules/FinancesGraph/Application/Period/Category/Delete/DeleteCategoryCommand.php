<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category\Delete;

final class DeleteCategoryCommand
{
    public function __construct(public readonly string $id){}
}
