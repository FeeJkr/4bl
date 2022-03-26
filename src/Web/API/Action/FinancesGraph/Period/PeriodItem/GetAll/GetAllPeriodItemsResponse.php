<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\PeriodItem\GetAll;

use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemCategoryDTO;
use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemDTO;
use App\Modules\FinancesGraph\Application\Period\PeriodItem\PeriodItemsCollection;
use App\Web\API\Action\Response;

final class GetAllPeriodItemsResponse extends Response
{
    public static function respond(PeriodItemsCollection $collection): self
    {
        return new self(
            array_map(
                static fn (PeriodItemDTO $periodItem) => [
                    'id' => $periodItem->id,
                    'periodId' => $periodItem->periodId,
                    'date' => $periodItem->date->format('Y-m-d'),
                    'items' => array_map(
                        static fn (PeriodItemCategoryDTO $category) => [
                            'id' => $category->id,
                            'periodItemId' => $category->periodItemId,
                            'categoryId' => $category->categoryId,
                            'amount' => $category->amount,
                        ],
                        $periodItem->items->items
                    )
                ],
                $collection->items
            )
        );
    }
}
