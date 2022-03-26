<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period\PeriodItem;

use App\Common\Domain\Entity;
use App\Modules\FinancesGraph\Domain\Period\Category\CategoryId;

final class PeriodItemCategory extends Entity
{
    public function __construct(
        private PeriodItemCategoryId $id,
        private PeriodItemId $periodItemId,
        private CategoryId $categoryId,
        private float $amount,
    ){}

    public function snapshot(): PeriodItemCategorySnapshot
    {
        return new PeriodItemCategorySnapshot(
            $this->id->toString(),
            $this->periodItemId->toString(),
            $this->categoryId->toString(),
            $this->amount,
        );
    }
}
