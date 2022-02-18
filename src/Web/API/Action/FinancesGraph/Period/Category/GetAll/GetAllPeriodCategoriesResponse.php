<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\Category\GetAll;

use App\Modules\FinancesGraph\Application\Period\Category\CategoriesCollection;
use App\Modules\FinancesGraph\Application\Period\Category\CategoryDTO;
use App\Web\API\Action\Response;

final class GetAllPeriodCategoriesResponse extends Response
{
    public static function respond(CategoriesCollection $collection): self
    {
        return new self(
            array_map(
                static fn (CategoryDTO $category) => [
                    'id' => $category->id,
                    'periodId' => $category->periodId,
                    'name' => $category->name,
                    'startBalance' => $category->startBalance,
                    'isMandatory' => $category->isMandatory,
                ],
                $collection->items,
            )
        );
    }
}
